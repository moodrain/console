<?php

namespace App\Models;

class Log extends Model
{
    public static $searchRule = [
        'id' => '=',
        'applicationId/d' => '=',
        'content' => 'like',
        'note' => 'like',
    ];
    public static $sortRule = ['id', 'applicationId', 'note'];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

}
