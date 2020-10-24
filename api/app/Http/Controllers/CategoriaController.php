<?php

namespace App\Http\Controllers;

use App\Model\Categoria;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\CategoriaResource;

class CategoriaController extends Controller
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
        return CategoriaResource::collection(Categoria::latest()->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Categoria::create($request->all());
        $categoria = new Categoria;
        $categoria->categoria = $request->categoria;
        $categoria->slug = str_slug($request->categoria);
        $categoria->save();
        return response('Created', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categorium)
    {
        return new CategoriaResource($categorium);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categorium)
    {
        $categorium->update(
            [
                'categoria' => $request->categoria,
                'slug' => str_slug($request->categoria)
            ]
        );
        return response('Updated', 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categorium)
    {
        $categorium->delete();
        // $categoria = Categoria::findOrfail($id);
        // $categoria->delete();
        return response('Deleted', 204);
    }
}
