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
            cache()->set('oss-bucket', $this->oss->buckets());
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

    }

    private $oss;

    public function __construct()
    {
        parent::__construct();
        $this->oss = new OssService();
    }

}