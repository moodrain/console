<?php

namespace App\Helpers;

class NavHelper
{
    public function resourceAdminNav($model, $prefix = 'admin')
    {
        $path = $prefix . ($prefix ? '/' : '') . str_replace('_', '/', $model);
        $name = str_replace('_', ' ', $model);
        return [$model, $name, [
            ["$model-list", "$name list", "$path/list"],
            ["$model-edit", "$name edit", "$path/edit"],
        ]];
    }

    public function resourceAdminNavs($models, $prefix = 'admin')
    {
        return array_map(function($model) use ($prefix) {
            return $this->resourceAdminNav($model, $prefix);
        }, $models);
    }
}