<?php

namespace App\Http\Controllers;

use App\Model\AvaliacaoComentario;
use Illuminate\Http\Request;
use App\Model\Comentario;

class AvaliacaoComentarioController extends Controller
{
    public function avaliar(Comentario $comentario, Request $request)
    {
        $avaliacao = new AvaliacaoComentario;
        $avaliacao->idComentario = $comentario->idComentario;
        $avaliacao->idUsuario = $request->idUsuario;
        $avaliacao->save();
    }

    public function deletarAvaliacao(Comentario $comentario, Request $request)
    {
        AvaliacaoComentario::where('idUsuario', $request->idUsuario)->where('idComentario', $comentario->idComentario)->first()->delete();
    }
}
