<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Factory;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $faker =  Factory::create('fr_FR');
    // configuration des données "fakes" avec un titre et une description généré via lorem ipsum
    return [
        'title' => $faker->sentence(),
        'description' => $faker->paragraph()
    ];
});
