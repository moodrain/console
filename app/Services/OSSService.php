<?php

namespace App\Services;

use OSS\OssClient;

class OSSService
{
    private static $oss;
    private static $buckets = [];

    public function __construct()
    {
        ! self::$oss && self::$oss = new OssClient(config('aliyun.accessKeyId'), config('aliyun.accessKeySecret'), config('aliyun.oss.endpoint'));
    }

    public function list($bucket, $prefix = null)
    {
        $options = ['max-keys' => 1000];
        $prefix && $options['prefix'] = endWith('/', $prefix);
        return self::$oss->listObjects($bucket, $options);
    }

    public function files($bucket, $prefix = null)
    {
        $files = $this->list($bucket, $prefix)->getObjectList();
        $rs = [];
        foreach($files as $file) {
            if ($file->getKey() == $prefix) {
                continue;
            }
            $rs[] = str_replace($prefix , '', $file->getKey());
        }
        return $rs;
    }

    public function directories($bucket, $prefix = null)
    {

        $prefixes = $this->list($bucket, $prefix)->getPrefixList();
        $rs = [];
        foreach($prefixes as $prefix) {
            $rs[] = $prefix;
        }
        return $rs;
    }

    public function buckets()
    {
        if (! self::$buckets) {
            $buckets = self::$oss->listBuckets()->getBucketList();
            foreach($buckets as $bucket) {
                self::$buckets[] = $bucket->getName();
            }
        }
        return self::$buckets;
    }

}