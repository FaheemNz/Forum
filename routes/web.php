<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index');

Auth::routes(['verify' => true]);

Route::group(['name' => 'thread'], function () {
    
    // Admin Thread Locking (Move upward to remove collision with thread update route)
    Route::group(['name' => 'thread.admin.lock', 'middleware' => ['isAdmin']], function () {
        Route::put('/threads/{thread}/lock', 'Thread\LockThreadController@update')->name('thread.lock');
    });
    
    Route::get('threads', 'Thread\ThreadController@index');
    Route::get('threads/create', 'Thread\ThreadController@create')->name('create_thread');
    Route::post('/threads', 'Thread\ThreadController@store')->name('store_thread');
    Route::put('/threads/{channel}/{thread}', 'Thread\ThreadController@update')->name('threads.update');
    Route::delete('threads/{channel}/{thread}', 'Thread\ThreadController@destroy')->name('delete_thread');

    // Channel Routes
    Route::group(['name' => 'thread.channels'], function () {
        Route::get('threads/{channel}/{thread}', 'Thread\ThreadController@show');
        Route::get('threads/{channel:slug}', 'Thread\ThreadController@index')->name('thread_channel');
    });

    // Reply Routes
    Route::group(['name' => 'thread.replies'], function () {
        Route::post('/threads/{channel}/{thread}/replies', 'Thread\ReplyController@store')->name('add_reply_to_thread');
        Route::delete('/replies/{reply}', 'Thread\ReplyController@destroy')->name('delete_reply');
        Route::put('/replies/{reply}', 'Thread\ReplyController@update');
        Route::get('/threads/{channel}/{thread}/replies', 'Thread\ReplyController@index');
    });

    // Favorites
    Route::group(['name' => 'reply.favorite', 'middleware' => ['auth']], function () {
        Route::post('/replies/{reply}/favorites', 'FavoriteController@store')->name('favorite_the_reply');
        Route::delete('/replies/{reply}/favorites', 'FavoriteController@destroy')->name('delete_favorite');
    });

    // Best Reply
    Route::group(['name' => 'reply.best', 'middleware' => ['auth']], function () {
        Route::post('/replies/{reply}/best', 'Thread\BestReplyController@store')->name('best-reply.store');
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

    // Avatar
    Route::group(['name' => 'thread.api', 'middleware' => ['auth']], function () {
        Route::post('/api/users/{user}/avatar', 'Api\AvatarController@store')->name('store_avatar');
    });
    
});
