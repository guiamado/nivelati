<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class ComentarioResource extends JsonResource
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
            'idComentario' => $this->idComentario,
            'descricaoComentario' => $this->descricaoComentario,
            'idPublicacao' => $this->idPublicacao,
            'usuario' => User::find($this->idUsuario)->name,
            'idUsuario' => $this->idUsuario,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
