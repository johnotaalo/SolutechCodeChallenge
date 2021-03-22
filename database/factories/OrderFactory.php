<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Order::class, function (Faker $faker) {
    return [
    	'order_number'	=>	"SOL-" . $faker->unique()->numberBetween(1000, 9999)
    ];
});
