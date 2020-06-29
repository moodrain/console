<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        $key = request('genKey') ? encrypt(config('app.api_key')) : null;
        return $this->view('index', ['key' => $key]);
    }
}