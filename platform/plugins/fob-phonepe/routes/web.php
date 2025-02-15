<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'fob-phonepe', 'as' => 'fob-phonepe.'], function () {
    Route::get('/', function () {
        return response()->json(['message' => 'FOB PhonePe Plugin Routes Loaded']);
    })->name('index');
});
