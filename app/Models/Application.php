<?php

namespace App\Models;

class Application extends Model
{
    public static $searchRule = [
        'id' => '=',
        'name' => 'like',
        'site' => 'like',
    ];

    public static $sortRule = ['id', 'name', 'createdAt'];

    public function wxMiniProgram()
    {
        return $this->hasOne(WxMiniProgram::class);
    }

    public function wxMsgTemps()
    {
        return $this->hasMany(WxMsgTemp::class);
    }

    public function qqConnectApp()
    {
        return $this->hasOne(QqConnectApp::class);
    }

}
