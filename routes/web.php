<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['name' => 'thread'], function () {
    Route::get('/threads', 'Thread\ThreadController@index');
    Route::get('/threads/{id}', 'Thread\ThreadController@show');

    Route::group(['name' => 'thread.replies', 'middleware' => ['auth']], function () {
        Route::post('/threads/{id}/replies', 'Thread\ReplyController@store')->name('add_reply_to_thread');
    });
});

Route::get('/home', 'HomeController@index')->name('home');
