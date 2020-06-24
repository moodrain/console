<?php

namespace App\Models;

class JsonStorage extends Model
{
    public static $searchRule = [
        'id' => '=',
        'name' => 'like',
        'applicationId' => '=',
    ];
    public static $sortRule = ['id', 'applicationId', 'name', 'createdAt', 'updatedAt'];

    protected $appends = ['dataJson'];
    protected $casts = [
        'data' => 'json',
    ];

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

}
