<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
use App\Model\Comentario;
use App\Model\Categoria;

class PublicacaoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'idPublicacao' => $this->idPublicacao,
            'titulo' => $this->titulo,
            'slug' => $this->slug,
            'descricaoPublicacao' => $this->descricaoPublicacao,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
            'usuario' => User::find($this->idUsuario)->name,
            'idUsuario' => $this->idUsuario,
            'comentarios' => Comentario::where('idPublicacao', $this->idPublicacao)->get()->count(),
            'categoria' => Categoria::find($this->idCategoria)->categoria
        ];
    }
}
