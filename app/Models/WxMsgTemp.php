<?php

namespace App\Models;

class WxMsgTemp extends Model
{
    public static $searchRule = [
        'id' => '=',
        'applicationId/d' => '=',
        'tempId' => '=',
    ];
    public static $sortRule = ['id', 'applicationId'];

    protected $casts = [
        'data' => 'json',
        'map' => 'json',
    ];

    protected $appends = ['dataJson', 'mapJson'];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function getDataJsonAttribute()
    {
        return $this->attributes['data'];
    }

    public function setDataJsonAttribute($dataJson)
    {
        $this->attributes['data'] = $dataJson;
    }

    public function getMapJsonAttribute()
    {
        return $this->attributes['map'];
    }

    public function setMapJsonAttribute($dataJson)
    {
        $this->attributes['map'] = $dataJson;
    }

}
