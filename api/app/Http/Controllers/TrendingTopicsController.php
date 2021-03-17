<?php

namespace App\Http\Controllers;

use App\Model\Comentario;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TrendingTopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Comentario::select(DB::raw('count(idPublicacao) as quantidade, idPublicacao, descricaoComentario'))->groupBy('idPublicacao')->orderBy('quantidade', 'desc')->limit(5)->get();
        $comentarios = Comentario::select(DB::raw('count(*) as quantidade, idPublicacao'))->groupBy('idPublicacao')->get();
        dd($comentarios);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByCategoria($categoria)
    {
        return Comentario::select(DB::raw('count(comentario.idPublicacao) as quantidade, comentario.idPublicacao, comentario.descricaoComentario'))
            ->join('publicacao', 'comentario.idPublicacao', '=', 'publicacao.idPublicacao')
            ->join('categoria', 'publicacao.idCategoria', '=', 'categoria.idCategoria')
            ->where('categoria.idCategoria', $categoria)
            ->groupBy('comentario.idPublicacao')
            ->orderBy('quantidade', 'desc')
            ->limit(5)
            ->get();
        $comentarios = Comentario::select(DB::raw('count(*) as quantidade, idPublicacao'))->groupBy('idPublicacao')->get();
        dd($comentarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
