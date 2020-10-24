<?php

namespace App\Gates;

class GateRegister
{

    public static function register()
    {

    }

    public static final function registerAll()
    {
        self::auto();
    }

    public static final function auto()
    {
        $files = scandir(__DIR__);
        foreach($files as $file) {
            if (in_array($file, ['.', '..', basename(__FILE__)])) {
                continue;
            }
            call_user_func(['App\\Gates\\' . substr($file, 0, -4), 'register']);
        }
    }
}