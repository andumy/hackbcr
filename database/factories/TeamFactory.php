<?php

use Faker\Generator as Faker;
use App\Team;

$factory->define(Team::class, function (Faker $faker) {
    return [
        'name' => $faker->numberBetween(0,100),
    ];
});
