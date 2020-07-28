<?php

namespace App\Http\Controllers\Api;

class NotifyController extends Controller
{
    public function notify($name = 'default')
    {
        $class = 'App\\Notifies\\' . ucfirst($name) . 'Notify';
        $object = new $class(request()->all());
        return rs($object->send());
    }
}