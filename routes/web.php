<?php

use Illuminate\Support\Facades\Route;

if (env('ICP')) {
    Route::view('/login', 'icp.login')->name('login');
    //Route::view('register', 'user.register');
    Route::post('login', 'ICPController@login');
    //Route::post('register', 'UserController@register');
} else {
    Route::view('/login', 'user.login')->name('login');
    //Route::view('register', 'user.register');
    Route::post('login', 'UserController@login');
    //Route::post('register', 'UserController@register');
}

Route::prefix('oa')->group(function() {

    Route::get('qq', 'OAController@qq');

    Route::prefix('callback')->group(function() {

        Route::get('qq/{application}', 'OAController@qqCallback');

    });

});


Route::middleware(['auth'])->group(function() {

    if (env('ICP')) {
        Route::get('/', 'IndexController@index');
    } else {
        Route::view('/', 'icp.index');
    }

    Route::post('logout', 'UserController@logout');

    Route::get('application/list', 'ApplicationController@list');
    Route::any('application/edit', 'ApplicationController@edit');
    Route::post('application/destroy', 'ApplicationController@destroy');

    Route::get('json-storage/list', 'JsonStorageController@list');
    Route::any('json-storage/edit', 'JsonStorageController@edit');
    Route::post('json-storage/destroy', 'JsonStorageController@destroy');

    Route::get('log/list', 'LogController@list');
    Route::post('log/destroy', 'LogController@destroy');

    Route::get('wx-msg-temp/list', 'WxMsgTempController@list');
    Route::any('wx-msg-temp/edit', 'WxMsgTempController@edit');
    Route::post('wx-msg-temp/destroy', 'WxMsgTempController@destroy');

    Route::get('wx-mini-program/list', 'WxMiniProgramController@list');
    Route::any('wx-mini-program/edit', 'WxMiniProgramController@edit');
    Route::post('wx-mini-program/destroy', 'WxMiniProgramController@destroy');

});

Route::view('wr/gui', 'word.read')->withoutMiddleware('web');
Route::get('wr/{text?}', 'Api\WordController@read')->withoutMiddleware('web');
