<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        $key = request('genKey') ? bcrypt(config('app.api_key')) : null;
        return $this->view('index', ['key' => $key]);
    }
}