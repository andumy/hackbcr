<?php

use Faker\Generator as Faker;
use App\Department;

$factory->define(Department::class, function (Faker $faker) {
    return [
        'name' => $faker->domainWord,
    ];
});
