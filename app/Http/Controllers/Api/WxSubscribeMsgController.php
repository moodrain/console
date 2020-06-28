<?php

namespace App\Http\Controllers\Api;

use App\Models\WxMsgTemp;
use App\Services\WxMiniProgramService;
use Illuminate\Support\Facades\Http;

class WxSubscribeMsgController extends Controller
{
    public function send(WxMiniProgramService $wxSrv)
    {
        $this->validate(request(), [
            'applicationId' => 'required|exists:applications:id',
            'templateId' => 'required|exists:wx_msg_temps:id',
            'openid' => 'required',
            'data' => 'array',
        ]);
        $accessToken = $wxSrv->accessToken(request('applicationId'));
        if (! $accessToken) {
            return rs(null, $wxSrv->errMsg(), 1);
        }
        $temp = WxMsgTemp::query()->find(request('templateId'));
        $data = $temp->data;
        foreach ($temp->map as $reqKey => $dataKey) {
            $data[$dataKey] = ['value' => request($reqKey)];
        }
        $rs = Http::asJson()->post('https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=' . $accessToken, [
            'template_id' => $temp->temp_id,
            'touser' => request('openid'),
            'data' => $data,
        ]);
        return rs($rs->json());
    }
}