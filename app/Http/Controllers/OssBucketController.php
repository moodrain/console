<?php

namespace App\Http\Controllers;

use App\Services\OssService;
use OSS\OssClient;

class OssBucketController extends Controller
{
    public function list()
    {
        $buckets = $this->oss->buckets();
        $list = [];
        foreach ($buckets as $bucket) {
            $list[] = [
                'name' => $bucket->getName(),
                'acl' => $this->oss->client($bucket->getExtranetEndpoint())->getBucketAcl($bucket->getName()),
            ];
        }
        return $this->view('oss-bucket.list', ['l' => $list]);
    }

    public function create()
    {
        $this->validate(request(), [
            'name' => 'required',
            'acl' => 'required|in:' . join(',', OssClient::$OSS_ACL_TYPES),
        ]);
        try {
            $this->oss->createBucket(request('name'), request('acl'));
            return $this->backOk();
        } catch (\Exception $e) {
            return $this->backErr($e->getMessage());
        }
    }

    public function destroy()
    {
        $this->validate(request(), ['name' => 'required']);
        try {
            $this->oss->dropBucket(request('name'));
            return $this->backOk();
        } catch (\Exception $e) {
            return $this->backErr($e->getMessage());
        }
    }

    public function acl()
    {
        $this->validate(request(), [
            'name' => 'required',
            'acl' => 'required|in:' . join(',', OssClient::$OSS_ACL_TYPES),
        ]);
        try {
            $this->oss->setBucketAcl(request('name'), request('acl'));
            return $this->backOk();
        } catch (\Exception $e) {
            return $this->backErr($e->getMessage());
        }
    }

    private $oss;

    public function __construct(OssService $oss)
    {
        parent::__construct();
        $this->oss = $oss;
    }
}