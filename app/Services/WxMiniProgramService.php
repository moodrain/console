<?php

namespace App\Services;

use App\Models\WxMiniProgram;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class WxMiniProgramService
{
    private $errMsg;

    public function accessToken($applicationId)
    {
        $mp = WxMiniProgram::query()->where('application_id', $applicationId)->first();
        if ($mp->access_token_expires_at > time()) {
            return $mp->access_token;
        }
        DB::beginTransaction();
        try {
            $mp->lockForUpdate();
            $rs = Http::get("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$mp->appid}&secret={$mp->appsecret}");
            if (! $rs->successful()) {
                self::$errMsg = 'request wx server failed: ' . $rs->body();
                DB::rollBack();
                return false;
            }
            $rs = $rs->json();
            $mp->access_token = $rs['access_token'];
            $mp->access_token_expires_at = time() + $rs['expires_in'];
            $mp->save();
            DB::commit();
            return $mp->access_token;
        } catch (\Exception $e) {
            self::$errMsg = $e->getMessage();
            DB::rollBack();
            return false;
        }
    }

    public function errMsg() {
        return self::$errMsg;
    }

}