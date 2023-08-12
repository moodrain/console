<?php

return [
    'oss' => [
        'bucket' => env('BACKUP_OSS_BUCKET='),
        'path' => 'db-backup',
    ],
];