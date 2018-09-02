<?php

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'address' => '12345 Fake Street, BC',
    ];
});
