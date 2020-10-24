<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RouteHelper
{
    public function resourceAdminRoute($model, $namespace = 'Admin')
    {
        $class = ucfirst(Str::camel($model));
        $path = '';
        $namespace && $path = join('/', array_map(function($e) { return Str::snake($e, '-'); }, explode('\\', $namespace)));
        $model = join('/', array_map(function($e) { return Str::snake($e, '-'); }, explode('\\', $model)));
        $path = strtolower($path . '/' . $model);
        $controller = endWith('\\', '\\App\\Http\\Controllers\\' . $namespace) . $class . 'Controller';
        Route::get("$path/list", [$controller, 'list']);
        Route::match(['get', 'post'], "$path/edit", [$controller, 'edit']);
        Route::post("$path/destroy", [$controller, 'destroy']);
    }

    public function resourceAdminRoutes($models, $namespace = 'Admin')
    {
        foreach ($models as $model) {
            $this->resourceAdminRoute($model, $namespace);
        }
    }
}