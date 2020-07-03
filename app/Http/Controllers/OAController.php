<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Support\Facades\Http;

class OAController extends Controller
{
    public function qq()
    {
        $application = Application::query()->find(request('id'));
        abort_if(! $application || $application->qqConnectApp, 404);
        $qq = $application->qqConnectApp;
        $query = [
            'response_type' => 'code',
            'client_id' => $qq->appid,
            'redirect_uri' => env('APP_URL') . '/oa/callback/qq/' . $application->id,
            'state' => 'moodrain',
        ];
        return redirect('https://graph.qq.com/oauth2.0/authorize?' . http_build_query($query));
    }

    public function qqCallback(Application $application)
    {
        abort_if(! $application || ! $application->qqConnectApp, 404);
        if (request('code')) {
            $qq = $application->qqConnectApp;
            $rs = Http::get('https://graph.qq.com/oauth2.0/token', [
                'grant_type' => 'authorization_code',
                'client_id' => $qq->appid,
                'client_secret' => $qq->appkey,
                'code' => request('code'),
                'redirect_uri' => env('APP_URL') . '/oa/callback/qq/' . $application->id,
                'fmt' => 'json',
            ]);
            $rs = $rs->json();
            $accessToken = $rs['access_token'];
            $expiresIn = $rs['expires_in'];
            $refreshToken = $rs['refresh_token'];
            $rs = HTTP::get('https://graph.qq.com/oauth2.0/me', [
                'access_token' => $accessToken,
                'fmt' => 'json',
            ]);
            $rs = $rs->json();
            $openid = $rs['openid'];
            $rs = HTTP::get('https://graph.qq.com/user/get_user_info', [
                'access_token' => $accessToken,
                'oauth_consumer_key' => $qq->appid,
                'openid' => $openid,
            ]);
            $rs = $rs->json();
            $rs['openid'] = $openid;
            $rs['access_token'] = $accessToken;
            $rs['expires_in'] = $expiresIn;
            $rs['refresh_token'] = $refreshToken;
            $param = [
                'oa' => 'qq',
                'oa_data' => urlencode(encrypt(json_encode($rs))),
            ];
            return redirect($qq->callbackUrl . '?' . http_build_query($param));
        }
    }
}