<?php

use App\Model\Publicacao;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\Model\Comentario::class, function (Faker $faker) {
    return [
        'descricaoComentario' => $faker->text,
        'idPublicacao' => function () {
            return Publicacao::all()->random()->idPublicacao;
        },
        'idUsuario' => function () {
            return User::all()->random()->idUsuario;
        },
    ];
});
