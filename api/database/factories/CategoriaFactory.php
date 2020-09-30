<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Categoria::class, function (Faker $faker) {
    $word = $faker->word;
    return [
        'categoria' => $word,
        'slug' => str_slug($word)

    ];
});
