<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index');

Auth::routes(['verify' => true]);

Route::group(['name' => 'thread'], function () {

    Route::get('threads', 'Thread\ThreadController@index');
    Route::get('threads/create', 'Thread\ThreadController@create')->name('create_thread');
    Route::post('/threads', 'Thread\ThreadController@store')->name('store_thread');
    Route::delete('threads/{channel}/{thread}', 'Thread\ThreadController@destroy')->name('delete_thread');

    // Channel Routes
    Route::group(['name' => 'thread.channels'], function () {
        Route::get('threads/{channel}/{id}', 'Thread\ThreadController@show');
        Route::get('threads/{channel:slug}', 'Thread\ThreadController@index')->name('thread_channel');
    });

    // Reply Routes
    Route::group(['name' => 'thread.replies'], function () {
        Route::post('/threads/{channel}/{thread}/replies', 'Thread\ReplyController@store')->name('add_reply_to_thread');
        Route::delete('/replies/{reply}', 'Thread\ReplyController@destroy')->name('delete_reply');
        Route::put('/replies/{reply}', 'Thread\ReplyController@update');
        Route::get('/threads/{channel}/{thread}/replies', 'Thread\ReplyController@index');
    });

    Route::group(['name' => 'api.thread.replies', 'middleware' => ['auth']], function () {
        Route::post('/replies/{reply}/favorites', 'FavoriteController@store')->name('favorite_the_reply');
        Route::delete('/replies/{reply}/favorites', 'FavoriteController@destroy')->name('delete_favorite');
    });

    // Profile Routes
    Route::group(['name' => 'thread.userProfile'], function () {
        Route::get('profiles/{user:name}', 'ProfileController@show')->name('profile');
        Route::get('/profiles/{user:name}/notifications', 'NotificationController@index');
        Route::delete('/profiles/{user:name}/notifications/{notification}', 'NotificationController@destroy');
    });

    // Thread Subscriptions
    Route::group(['name' => 'thread.subscription'], function () {
        Route::post('/threads/{channel}/{thread}/subscriptions', 'Thread\ThreadSubscriptionController@store');
        Route::delete('/threads/{channel}/{thread}/subscriptions', 'Thread\ThreadSubscriptionController@destroy');
    });

    Route::group(['name' => 'thread.api', 'middleware' => ['auth']], function () {
        Route::post('/api/users/{user}/avatar', 'Api\AvatarController@store')->name('store_avatar');
    });
});
