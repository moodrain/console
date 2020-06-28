<?php

return [

    // 0 => index, 1 => name, 2 => url/submenu
    'nav' => [
        ['index', 'Dashboard', ''],
        ['application', 'Application', [
            ['application-list', 'App List', 'application/list'],
            ['application-edit', 'App Edit', 'application/edit'],
        ]],
        ['json-storage', 'Json Storage', [
            ['json-storage-list', 'Json List', 'json-storage/list'],
            ['json-storage-edit', 'Json Edit', 'json-storage/edit'],
        ]],
        ['log-list', 'Log', 'log/list'],
        ['wx-msg-temp', 'Wx Msg Temp', [
            ['wx-msg-temp-list', 'Temp List', 'wx-msg-temp/list'],
            ['wx-msg-temp-edit', 'Temp Edit', 'wx-msg-temp/edit'],
        ]],
    ],

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

];
