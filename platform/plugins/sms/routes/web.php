<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'sms', 'as' => 'sms.'], function () {
    Route::get('/', function () {
        return response()->json(['message' => 'SMS Plugin Routes Loaded']);
    });
});
