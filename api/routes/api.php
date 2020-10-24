<?php

use Illuminate\Http\Request;


Route::group([
    'middleware' => ['cors'],
], function () {
     Route::apiResource('/publicacao', 'PublicacaoController');
     Route::apiResource('/categoria', 'CategoriaController');
     Route::apiResource('/publicacao/{publicacao}/comentario', 'ComentarioController');
     Route::post('/avaliacaoComentario/{comentario}', 'AvaliacaoComentarioController@avaliar');
     Route::delete('/avaliacaoComentario/{comentario}', 'AvaliacaoComentarioController@deletarAvaliacao');
});

Route::group([

    'middleware' => ['cors', 'api'],
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});