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
        $directories = request('bucket') ? $this->oss->directories(request('bucket'), request('path')) : [];
        $files = request('bucket') ? $this->oss->files(request('bucket'), request('path')) : [];
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