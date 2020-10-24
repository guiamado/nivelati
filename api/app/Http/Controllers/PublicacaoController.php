<?php

namespace App\Http\Controllers;

use App\Model\Publicacao;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\PublicacaoResource;

class PublicacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index', 'show']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PublicacaoResource::collection(Publicacao::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Publicacao::create($request->all());
        return response('Created', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Publicacao  $publicacao
     * @return \Illuminate\Http\Response
     */
    public function show(Publicacao $publicacao)
    {
        return new PublicacaoResource($publicacao);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Publicacao  $publicacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publicacao $publicacao)
    {
        $publicacao->update($request->all());
        return response('Updated', 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Publicacao  $publicacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publicacao $publicacao)
    {
        $publicacao->delete();
        // return new PublicacaoResource(['statusCode' => 204, 'status' => 'Deleted']);
        return response('Deleted', 204);
    }
}
