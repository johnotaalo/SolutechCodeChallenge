<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Product::class, function (Faker $faker) {
    return [
        'name'			=>	$faker->name,
        'description'	=>	$faker->realText(45),
        'quantity'      =>  $faker->numberBetween(1, 100)
    ];
});
