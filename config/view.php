<?php

$helper = new \App\Helpers\NavHelper();

return [

    'admin' => [
        'nav' => [],
    ],

    'user' => [
        'nav' => [
            'pc' => [
                ['app-deploy', 'application', 'app/deploy'],
                ['dns', 'DNS', 'dns/put'],
                ['oss', 'OSS', [
                    ['oss-list', 'Oss list', 'oss/list'],
                    ['oss-edit', 'Oss edit', 'oss/edit'],
                    ['oss-bucket-list', 'Bucket list', 'oss-bucket/list'],
                ]],
                ['cdn', 'CDN', 'cdn/refresh'],
                ['db-backup', 'db-backup', [
                    ['db-backup_task-list', 'task list', 'db-backup/task/list'],
                    ['db-backup_task-edit', 'task edit', 'db-backup/task/edit'],
                    ['db-backup_database-list', 'database list', 'db-backup/database/list'],
                    ['db-backup_database-edit', 'database edit', 'db-backup/database/edit'],
                    ['db-backup_connection-list', 'connection list', 'db-backup/connection/list'],
                    ['db-backup_connection-edit', 'connection edit', 'db-backup/connection/edit'],
                ]]
            ],
            'mobile' => [],
        ],
    ],

    'nav' => [
        'auth' => [],
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
