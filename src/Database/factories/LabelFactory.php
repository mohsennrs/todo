<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Hattori\ToDo\Models\Label;
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

$factory->define(Label::class, function (Faker $faker) {
    return [
        'text' =>  $faker->unique()->word(),
        'user_id' => rand(),
    ];
});
