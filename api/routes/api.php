<?php

use Illuminate\Http\Request;


Route::group([
    'middleware' => ['cors'],
], function () {
     Route::apiResource('/publicacao', 'PublicacaoController');
});
