<?php

use Illuminate\Support\Facades\Route;

Route::view('/login', 'user.login')->name('login');
//Route::view('register', 'user.register');
Route::post('login', 'UserController@login');
//Route::post('register', 'UserController@register');


Route::middleware(['auth'])->group(function() {

    Route::get('/', 'IndexController@index');
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

});

Route::view('wr/gui', 'word.read');
Route::get('wr/{text?}', 'Api\WordController@read');
