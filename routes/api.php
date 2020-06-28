<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['api_token'])->namespace('Api')->group(function() {

    Route::post('mail/send', 'MailController@send');

    Route::get('json/get', 'JsonStorageController@get');
    Route::post('json/set', 'JsonStorageController@set');
    Route::post('json/increment', 'JsonStorageController@increment');
    Route::post('json/delete', 'JsonStorageController@destroy');

    Route::post('sms/captcha/send', 'SMSController@sendCaptcha');
    Route::post('sms/captcha/verify', 'SMSController@verifyCaptcha');

    Route::post('log', 'LogController@log');

    Route::post('wx/msg/send', 'WxSubscribeController@send');

});
