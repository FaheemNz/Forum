<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'user_id' => fn () => factory('App\User')->create()->id,
        'channel_id' => fn() => factory('App\Channel')->create()->id,
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
    ];
});

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph,
        'thread_id' => fn() => factory('App\Thread')->create()->id,
        'user_id' => fn () => factory('App\User')->create()->id,
    ];
});

$factory->define(Channel::class, function (Faker $faker) {
    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => $name
    ];
});
