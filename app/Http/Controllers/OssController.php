<?php

namespace App\Http\Controllers;

use App\Services\OssService;
use Illuminate\Support\Str;

class OssController extends Controller
{
    public function list()
    {
        $this->validate(request(), [
            'bucket' => '',
            'path' => '',
        ]);
        $bucketInfos = $this->oss->buckets();
        if (! $bucketInfos) {
            return $this->view('oss.list', ['directories' => [], 'files' => [], 'buckets' => [], 'bucket' => '', 'endpoint' => '']);
        }
        $buckets = array_map(function($e) {
            return $e->getName();
        }, $bucketInfos);
        $bucket = request('bucket', $buckets[0]);
        foreach ($bucketInfos as $bucketInfo) {
            if ($bucketInfo->getName() == $bucket) {
                $endpoint = $bucketInfo->getExtranetEndpoint();
            }
        }
        $directories = $this->oss->directories($bucket, request('path'));
        $files = $this->oss->files($bucket, request('path'));
        for ($i = 0; $i < count($directories); $i++) {
            $directories[$i] = ['name' => $directories[$i]];
        }
        for ($i = 0; $i < count($files); $i++) {
            $files[$i] = ['name' => $files[$i]];
        }
        return $this->view('oss.list', compact('directories', 'files', 'buckets', 'bucket', 'endpoint'));
    }

    public function edit()
    {
        if (request()->isMethod('get')) {
            $buckets = $this->oss->buckets();
            return $this->view('oss.edit', ['buckets' => $buckets]);
        }
        $this->validate(request(), [
            'path' => 'required',
            'bucket' => 'required',
            'content' => 'required',
        ]);
        $path = request('path');
        Str::startsWith($path, '/') && $path = mb_substr($path, 1);
        try {
            $this->oss->put(request('bucket'), $path, request('content'));
            return $this->backOk();
        } catch (\Exception $e) {
            return $this->backErr($e->getMessage());
        }
    }

    public function upload()
    {
        $this->validate(request(), [
            'file' => 'file',
            'path' => 'required',
            'bucket' => 'required',
        ]);
        $file = request()->file('file');
        $content = file_get_contents($file->getRealPath());
        $path = request('path');
        Str::startsWith($path, '/') && $path = mb_substr($path, 1);
        try {
            $this->oss->putFromFile(request('bucket'), $path, $file->getRealPath());
            return rs(ctype_print($content) ? $content : null);
        } catch (\Exception $e) {
            return ers($e->getMessage());
        }
    }

    public function destroy()
    {
        $this->validate(request(), [
            'file' => 'required',
            'bucket' => 'required',
        ]);
        $file = request('file');
        Str::startsWith($file, '/') && $file = mb_substr($file, 1);
        try {
            $this->oss->delete(request('bucket'), $file);
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