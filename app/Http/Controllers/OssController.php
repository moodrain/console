<?php

namespace App\Http\Controllers;


use App\Services\OssService;

class OssController extends Controller
{

    protected $model = 'oss';

    public function list()
    {
        $this->validate(request(), [
           'bucket' => '',
           'path' => '',
        ]);
        if (! cache('oss-bucket')) {
            try {
                cache()->set('oss-bucket', $this->oss->buckets());
            } catch (\Exception $e) {
                return $this->backErr($e->getMessage());
            }
        }
        $directories = request('bucket') ? $this->oss->directories(request('bucket'), request('path')) : [];
        $files = request('bucket') ? $this->oss->files(request('bucket'), request('path')) : [];
        for ($i = 0; $i < count($directories); $i++) {
            $directories[$i] = ['name' => $directories[$i]];
        }
        for ($i = 0; $i < count($files); $i++) {
            $files[$i] = ['name' => $files[$i]];
        }
        return $this->view('list', compact('directories', 'files'));
    }

    public function edit()
    {
        if (request()->isMethod('get')) {
            return $this->view('edit');
        }
        $this->validate(request(), [
            'path' => 'required',
            'bucket' => 'required',
            'content' => 'required',
        ]);
        try {
            $this->oss->put(request('bucket'), request('path'), request('content'));
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
        try {
            $this->oss->putFromFile(request('bucket'), request('path'), $file->getRealPath());
            return rs($content);
        } catch (\Exception $e) {
            return ers($e->getMessage());
        }
    }

    public function delete()
    {
        $this->validate(request(), [
            'file' => 'required',
            'bucket' => 'required',
        ]);
        try {
            $this->oss->delete(request('bucket'), request('file'));
            return $this->backOk();
        } catch (\Exception $e) {
            return $this->backErr($e->getMessage());
        }
    }

    private $oss;

    public function __construct()
    {
        parent::__construct();
        $this->oss = new OssService();
    }

}