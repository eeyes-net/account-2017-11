<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $user;
    $user = $user ?: \App\User::first();
    $data = $user->toArray();
    unset($data['id']);
    unset($data['role_ids']);
    $data['username'] = 'test_user_' . ($data['user_id'] = $faker->numberBetween(1000000000, 5999999999));
    $data['password'] = '*';
    return $data;
});
