<?php

namespace App\Http\Controllers;

use App\Model\Comentario;
use App\Model\Publicacao;
use Illuminate\Http\Request;
use App\Http\Resources\ComentarioResource;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Publicacao $publicacao)
    {
        return ComentarioResource::collection(Comentario::where('idPublicacao', $publicacao->idPublicacao)->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Publicacao $publicacao, Request $request)
    {
        $comentario = new Comentario;
        $comentario->descricaoComentario = $request->descricaoComentario;
        $comentario->idUsuario = $request->idUsuario;
        $comentario->idPublicacao = $request->idPublicacao;
        $comentario->save();
        return response(['comentario' => new ComentarioResource($comentario)], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function show(Publicacao $publicacao, Comentario $comentario)
    {
        return new ComentarioResource($comentario);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function update(Publicacao $publicacao, Request $request, Comentario $comentario)
    {
        $comentario->update($request->all());
        return response('Updated', 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publicacao $publicacao, Comentario $comentario)
    {
        $comentario->delete();
        return response('Deleted', 204);
    }
}
