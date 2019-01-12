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

$factory->define(App\Models\Employee::class, function (Faker $faker) {
    $id = rand(19900716,20181012);
    $s = substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 1).'.'.
        substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 1).'.'.
        substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 1).'.';
    return [
        'id'=> $id,
        'initials' => $s,
        'last_name' => $faker->lastName,
        'full_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'date_of_birth' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'title_id' => rand(1,2),
        'nic' => rand(111111111,999999999).'V',
        'gender_id' => rand(1,2),
        'marital_status_id' => rand(1,2),
        'address' => $faker->address,
        'mobile' => '07'.rand(1,8).rand(1111111,9999999),
        'land' => '07'.rand(1,8).rand(1111111,9999999),
        'designation_id' => rand(1,3),
        'date_of_join' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'img_url'=> '/img/users/'.$id.'.jpg',
        'users_id'=> null,
    ];
});
