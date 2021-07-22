<?php

use Illuminate\Support\Facades\Route;

Route::middleware('throttle:1000,1')->group(function () {
    Route::post('/users/add', 'App\Http\Controllers\UserController@create');

    Route::post('/chats/get', 'App\Http\Controllers\ChatController@getUserChats');
    Route::post('/chats/add', 'App\Http\Controllers\ChatController@create');

    Route::post('/messages/get', 'App\Http\Controllers\MessageController@getMessage');
    Route::post('/messages/add', 'App\Http\Controllers\MessageController@create');
});

