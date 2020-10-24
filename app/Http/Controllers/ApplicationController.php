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
            expIf(! chdir($path), 'path not-found');
            exec('git pull', $output, $code);
            expIf($code !== 0, 'git pull failed: ' . join(PHP_EOL, $output));
            return $this->backOk();
        } catch (\Exception $e) {
            return $this->backErr($e->getMessage());
        }
    }
}