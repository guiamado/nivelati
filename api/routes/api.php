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
