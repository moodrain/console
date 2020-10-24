<?php

use Illuminate\Support\Facades\Route;

Route::any('login', [\App\Http\Controllers\UserController::class, 'login'])->name('login');
//Route::any('register', [\App\Http\Controllers\UserController::class, 'register']);

Route::middleware(['auth'])->group(function() {

    Route::view('/', 'index');
    Route::post('logout', [\App\Http\Controllers\UserController::class, 'logout']);

    Route::any('app/deploy', [\App\Http\Controllers\ApplicationController::class, 'deploy']);

    Route::view('dns/put', 'dns.put');
    Route::post('dns/put', [\App\Http\Controllers\DNSController::class, 'put']);

    Route::view('cdn/refresh', 'cdn.refresh');
    Route::post('cdn/refresh', [\App\Http\Controllers\CDNController::class, 'refresh']);

    Route::get('db-backup/connection/list', [\App\Http\Controllers\DbBackup\ConnectionController::class, 'list']);
    Route::any('db-backup/connection/edit', [\App\Http\Controllers\DbBackup\ConnectionController::class, 'edit']);
    Route::post('db-backup/connection/destroy', [\App\Http\Controllers\DbBackup\ConnectionController::class, 'destroy']);

    Route::get('db-backup/database/list', [\App\Http\Controllers\DbBackup\DatabaseController::class, 'list']);
    Route::any('db-backup/database/edit', [\App\Http\Controllers\DbBackup\DatabaseController::class, 'edit']);
    Route::post('db-backup/database/destroy', [\App\Http\Controllers\DbBackup\DatabaseController::class, 'destroy']);

    Route::get('db-backup/task/list', [\App\Http\Controllers\DbBackup\TaskController::class, 'list']);
    Route::any('db-backup/task/edit', [\App\Http\Controllers\DbBackup\TaskController::class, 'edit']);
    Route::post('db-backup/task/destroy', [\App\Http\Controllers\DbBackup\TaskController::class, 'destroy']);

    Route::get('oss-bucket/list', [\App\Http\Controllers\OssBucketController::class, 'list']);
    Route::post('oss-bucket/create', [\App\Http\Controllers\OssBucketController::class, 'create']);
    Route::post('oss-bucket/destroy', [\App\Http\Controllers\OssBucketController::class, 'destroy']);
    Route::post('oss-bucket/acl', [\App\Http\Controllers\OssBucketController::class, 'acl']);

    Route::get('oss/list', [\App\Http\Controllers\OssController::class, 'list']);
    Route::any('oss/edit', [\App\Http\Controllers\OssController::class, 'edit']);
    Route::any('oss/destroy', [\App\Http\Controllers\OssController::class, 'destroy']);
    Route::post('oss/upload', [\App\Http\Controllers\OssController::class, 'upload']);

});


require __DIR__ . '/admin.php';