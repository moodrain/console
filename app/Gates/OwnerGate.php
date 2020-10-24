<?php

namespace App\Gates;

use Illuminate\Support\Facades\Gate;

class OwnerGate extends GateRegister
{
    public static function register()
    {
        Gate::define('own', function($user, $model, $ownerKey = 'user_id') {
            $ownerKey = $ownerKey ?? 'user_id';
            return $user->id === $model->$ownerKey;
        });
    }
}