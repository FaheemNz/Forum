<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::group(['name' => 'thread'], function () {

    Route::get('threads', 'Thread\ThreadController@index');
    Route::get('threads/create', 'Thread\ThreadController@create')->name('create_thread');
    Route::post('/threads', 'Thread\ThreadController@store')->name('store_thread');
    Route::delete('threads/{channel}/{thread}', 'Thread\ThreadController@destroy')->name('delete_thread');
    
    Route::group(['name' => 'thread.channels'], function () {
        Route::get('threads/{channel}/{id}', 'Thread\ThreadController@show');
        Route::get('threads/{channel:slug}', 'Thread\ThreadController@index')->name('thread_channel');
    });

    Route::group(['name' => 'thread.replies', 'middleware' => ['auth']], function () {
        Route::post('/threads/{channel}/{id}/replies', 'Thread\ReplyController@store')->name('add_reply_to_thread');
        Route::post('/replies/{reply}/favorites', 'FavoriteController@store')->name('favorite_the_reply');
    });

    Route::group(['name' => 'thread.userProfile', 'middleware' => ['auth']], function () {
        Route::get('profiles/{user:name}', 'ProfileController@show')->name('profile');
    });
});
