<?php

use OSS\OssClient;

class OSSService
{
    private static $oss;
    private static $buckets;

    public function __construct()
    {
        ! $this->oss && $this->oss = new OssClient(config('aliyun.accessKeyId'), config('aliyun.accessKeySecret'), config('aliyun.oss.endpoint'));
    }

    public function list($bucket, $prefix)
    {
        $objects = [];
        $this->oss->listObjects($bucket)
    }

    public function buckets()
    {
        ! $this->buckets && $this->buckets = $this->oss->listBuckets();
        return
    }

}