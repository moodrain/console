<?php

namespace App\Http\Controllers\Api;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class SMSController extends Controller
{
    public function sendCaptcha()
    {
        $ip = request()->getClientIp();
        $date = date('YmdH');
        if (cache()->increment("aliyun_captcha_send_times_{$ip}_{$date}") > 10) {
            return rs(null, 'to many request', 1);
        }
        $this->initAliClient();
        $this->validate(request(), [
            'code' => 'int|between:1000,9999',
            'phone' => ['regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/'],
            'applicationId' => 'exists:applications,id',
        ]);
        $code = request('code') ?? mt_rand(1000, 9999);
        $phone = request('phone');
        $applicationId = request('applicationId');
        if ($applicationId) {
            $key = "aliyun_captcha_{$applicationId}_{$phone}";
            cache()->put($key, $code, 60 * 5);
        }
        try {
            AlibabaCloud::rpc()->product('Dysmsapi')
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'PhoneNumbers' => request('phone'),
                        'SignName' => config('aliyun.smsSignName'),
                        'TemplateCode' => config('aliyun.smsCaptchaTemplateCode'),
                        'TemplateParam' => json_encode(['code' => $code]),
                    ]
                ])->request();
        } catch (ClientException $e) {
            return rs(null, $e->getErrorMessage(), 1);
        } catch (ServerException $e) {
            return rs(null, $e->getErrorMessage(), 1);
        }
        return rs();
    }

    public function verifyCaptcha()
    {
        $this->validate(request(), [
            'code' => 'required|int|between:1000,9999',
            'phone' => ['required', 'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/'],
            'applicationId' => 'required|exists:applications,id',
        ]);
        $code = request('code');
        $phone = request('phone');
        $applicationId = request('applicationId');
        $date = date('YmdH');
        if (cache()->increment("aliyun_captcha_try_times_{$applicationId}_{$phone}_{$date}") > 10) {
            return rs(null, 'to many tries', 1);
        }
        $key = "aliyun_captcha_{$applicationId}_{$phone}";
        if (cache($key) != $code) {
            return rs(null, 'code not match', 1);
        }
        cache()->delete($key);
        return rs();
    }

}