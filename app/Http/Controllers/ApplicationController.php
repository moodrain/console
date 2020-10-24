<?php

namespace App\Http\Controllers;

class ApplicationController extends Controller
{
    public function deploy()
    {
        if (request()->isMethod('get')) {
            return $this->view('app.deploy');
        }
        $this->vld(['path' => 'required']);
        $path = request('path');
        try {
            chdir($path);
            exec('git pull', $output, $code);
            expIf($code !== 0, 'git pull failed: ' . join(PHP_EOL, $output));
            return $this->viewOk('app.deploy', ['path' => request('path')]);
        } catch (\Exception $e) {
            return $this->backErr($e->getMessage());
        }
    }
}