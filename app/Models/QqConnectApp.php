<?php

namespace App\Models;

class QqConnectApp extends Model
{
    public static $searchRule = [
        'id' => '=',
        'applicationId/d' => '=',
        'appid' => '=',
    ];
    public static $sortRule = ['id', 'applicationId'];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

}
