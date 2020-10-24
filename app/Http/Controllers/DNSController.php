<?php

namespace App\Http\Controllers;

use AlibabaCloud\Client\AlibabaCloud;

class DNSController extends Controller
{
    public function put()
    {
        $this->validate(request(), [
            'domain' => 'required',
            'rr' => 'required',
            'value' => 'required',
            'type' => 'required',
        ]);
        $this->initAliClient();
        try {
            $result = AlibabaCloud::rpc()
                ->product('Alidns')->scheme('https')->version('2015-01-09')->action('DescribeDomainRecords')->method('POST')->host('alidns.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => 'cn-hangzhou',
                        'DomainName' => request('domain'),
                        'KeyWord' => request('rr'),
                        'SearchMode' => 'EXACT',
                    ],
                ])->request();
            $result = $result->toArray();
            $action = $result['TotalCount'] === 0 ? 'AddDomainRecord' : 'UpdateDomainRecord';
            $result['TotalCount'] !== 0 && $recordId = $result['DomainRecords']['Record'][0]['RecordId'];
            $result = AlibabaCloud::rpc()
                ->product('Alidns')->scheme('https')->version('2015-01-09')->action($action)->method('POST')->host('alidns.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => 'cn-hangzhou',
                        'DomainName' => request('domain'),
                        'RR' => request('rr'),
                        'Type' => request('type'),
                        'Value' => request('value'),
                        'RecordId' => $recordId ?? null,
                    ],
                ])->request();
            $result = $result->toArray();
            $result = json_encode($result, 128|256);
            return $this->viewOk('dns.put', ['result' => $result, 'd' => request()->all()]);
        } catch (\Exception $e) {
            return $this->backErr($e->getMessage());
        }
    }

    protected function initAliClient($regionId = 'cn-hangzhou')
    {
        AlibabaCloud::accessKeyClient(config('aliyun.accessKeyId'), config('aliyun.accessKeySecret'))
            ->regionId($regionId)
            ->asDefaultClient();
    }
}