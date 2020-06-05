<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Factory;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $faker =  Factory::create('fr_FR');
    return [
        'title' => $faker->sentence(),
        'description' => $faker->paragraph()
    ];
});
