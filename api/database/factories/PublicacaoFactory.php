<?php

use App\Model\Categoria;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\Model\Publicacao::class, function (Faker $faker) {
    $title = $faker->sentence;
    return [
        'titulo' => $title,
        'slug' => str_slug($title),
        'descricaoPublicacao' => $faker->text,
        'idCategoria' => function () {
            return Categoria::all()->random()->idCategoria;
        },
        'idUsuario' => function () {
            return User::all()->random()->idUsuario;
        }
    ];
});
