<?php

use App\Model\Comentario;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\Model\AvaliacaoComentario::class, function (Faker $faker) {
    return [
        'idUsuario' => function () {
            return User::all()->random()->idUsuario;
        },
        'idComentario' => function () {
            return Comentario::all()->random()->idComentario;
        }
    ];
});
