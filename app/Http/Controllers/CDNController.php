<?php

namespace App\Http\Controllers;

use AlibabaCloud\Client\AlibabaCloud;

class CDNController extends Controller
{
    public function refresh()
    {
        $this->validate(request(), [
            'url' => 'required',
            'isDir' => 'in:true,false',
        ]);
        $data = request()->all();
        $data['isDir'] = $data['isDir'] == 'true' ? true : false;
        $data['isDir'] && ! str_ends_with($data['url'], '/') && ($data['url'] .= '/');
        $this->initAliClient();
        try {
            $result = AlibabaCloud::rpc()->product('Cdn')->scheme('https')->version('2018-05-10')->method('POST')->host('cdn.aliyuncs.com')
                ->action('RefreshObjectCaches')
                ->options([
                    'query' => [
                        'RegionId' => 'cn-hangzhou',
                        'ObjectPath' => $data['url'],
                        'ObjectType' => $data['isDir'] ? 'Directory' : 'File',
                    ],
                ])->request();
            $result = $result->toArray();
            $result = json_encode($result, 128|256);
            return $this->viewOk('cdn.refresh', ['result' => $result, 'd' => $data]);
        } catch (\Exception $e) {
            return $this->backErr($e->getMessage());
        }
    }
}