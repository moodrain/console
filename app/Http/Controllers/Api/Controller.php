<?php

namespace App\Http\Controllers\Api;

use AlibabaCloud\Client\AlibabaCloud;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function vld($rules) {
        return $this->validate(request(), $rules);
    }

    protected function initAliClient($regionId = 'cn-hangzhou')
    {
        AlibabaCloud::accessKeyClient(config('aliyun.accessKeyId'), config('aliyun.accessKeySecret'))
            ->regionId($regionId)
            ->asDefaultClient();
    }

}
