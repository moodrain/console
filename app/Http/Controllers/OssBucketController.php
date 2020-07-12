<?php

namespace App\Http\Controllers;

use App\Services\OssService;
use OSS\OssClient;

class OssBucketController extends Controller
{

    protected $model = 'oss-bucket';

    public function list()
    {
        $buckets = $this->oss->buckets();
        $d = [];
        foreach($buckets as $bucket) {
            $d[] = ['name' => $bucket];
        }
        return $this->view('list', compact('d'));
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

    public function drop()
    {
        $this->validate(request(), ['name' => 'required',]);
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

    public function refresh()
    {
        $buckets = $this->oss->buckets();
        cache()->set('oss-bucket', $buckets);
        return $this->backOk();
    }

    private $oss;

    public function __construct()
    {
        parent::__construct();
        $this->oss = new OssService();
    }

}