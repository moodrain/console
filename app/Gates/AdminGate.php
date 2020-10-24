<?php

namespace App\Gates;

use Illuminate\Support\Facades\Gate;

class AdminGate extends GateRegister
{
    public static function register()
    {
        Gate::define('admin', function($user) {
            return $user->id === 1;
        });
    }
}