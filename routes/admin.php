<?php

use Illuminate\Support\Facades\Route;

$helper = new \App\Helpers\RouteHelper();

Route::middleware(['auth', 'can:admin'])->group(function() use ($helper) {



});