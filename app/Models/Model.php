<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model as LaravelModel;
use Illuminate\Support\Str;

class Model extends LaravelModel
{

    protected $hidden = ['deleted_at'];
    protected $guarded = ['id'];

    public static $searchRule = ['id' => '='];
    public static $sortRule = ['id', 'createdAt', 'updatedAt'];

    public static $snakeAttributes = false;

    public function getAttribute($key)
    {
        return parent::getAttribute(Str::snake($key));
    }

    public function setAttribute($key, $value)
    {
        return parent::setAttribute(Str::snake($key), $value);
    }

    public function attributesToArray()
    {
        $array = parent::attributesToArray();
        $new = [];
        foreach ($array as $key => $value) {
            $new[Str::camel($key)] = $value;
        }
        return $new;
    }

    public function relationsToArray()
    {
        $relations = parent::relationsToArray();
        $new = [];
        foreach ($relations as $relation => $attribute) {
            if (is_array($attribute)) {
                $new[$relation] = [];
                foreach ($attribute as $key => $value) {
                    $new[$relation][Str::camel($key)] = $value;
                }
            } else {
                $new[$relation] = $attribute;
            }
        }
        return $new;
    }

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}
