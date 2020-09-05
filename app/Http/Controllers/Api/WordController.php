<?php

namespace App\Http\Controllers\Api;

use AlibabaCloud\Client\AlibabaCloud;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use function GuzzleHttp\Psr7\mimetype_from_extension;

class WordController extends Controller
{
    public function read($text = null)
    {
        if ($text) {
            $decode = base64_decode($text);
            $decode && $text = $decode;
        } else {
            $text = request('text') ?? base64_decode(request('textBase64'));
        }
        if (! $text) {
            return null;
        }
        $this->validate(request(), [
            'format' => '',
            'voice' => '',
            'volume' => 'int|between:0,100',
            'speechRate' => 'int|between:-500,500',
            'pitchRate' => 'int|between:-500,500',
        ]);
        $voiceKey = 'aliTts:' . md5($text);
        $tokenKey = 'aliNlsToken_' . config('aliyun.ttsAppKey');
        $voice = cache($voiceKey);
        if ($voice) {
            return response($voice)->header('Content-Type', mimetype_from_extension(request('format', 'mp3')));
        }
        $token = cache($tokenKey);
        if (! $token) {
//            $lock = Cache::lock($tokenKey, 10);
//            if ($lock->get()) {
                $this->initAliClient('cn-shanghai');
                $rs = AlibabaCloud::nlsCloudMeta()
                    ->v20180518()
                    ->createToken()
                    ->request()->toArray();
                $tokenInfo = $rs['Token'] ?? null;
                if (! $tokenInfo) {
                    return rs(null, 'request a token from ali failed', 1);
                }
                $token = $tokenInfo['Id'];
                cache()->set($tokenKey, $token, $tokenInfo['ExpireTime'] - time());
//                $lock->release();
//            }
        }
        $rs = Http::asJson()->post('https://nls-gateway.cn-shanghai.aliyuncs.com/stream/v1/tts', [
            'appkey' => config('aliyun.ttsAppKey'),
            'text' => $text,
            'token' => $token,
            'format' => request('format', 'mp3'),
            'voice' => request('voice', 'Aijia'),
            'volume' => request('volume', 50),
            'speech_rate' => request('speech_rate', 0),
            'pitch_rate' => request('pitch_rate', 0),
        ]);
        cache()->set($voiceKey, $rs->body(), 86400 * 7);
        return response($rs->body())->header('Content-Type', mimetype_from_extension(request('format', 'mp3')));
    }

    public function segment()
    {
        $this->validate(request(), ['text' => 'required']);
        $text = preg_replace('/[^\x{4e00}-\x{9fa5}]/u', '', request('text'));
        $this->initAliClient('cn-shanghai');
        $result = AlibabaCloud::roa()->product('nlp')->version('2018-04-08')
            ->pathPattern('/nlp/api/wordsegment/general')
            ->method('POST')
            ->body(json_encode(['text' => $text]))
            ->request();
        return rs(array_column($result->toArray()['data'] ?? [], 'word'));
    }

}