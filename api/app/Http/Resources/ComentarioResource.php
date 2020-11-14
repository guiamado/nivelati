<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
use App\Model\AvaliacaoComentario;

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
        // dd(AvaliacaoComentario::where('idUsuario', auth()->id())->where('idComentario', $this->idComentario)->count());
        return [
            'idComentario' => $this->idComentario,
            'descricaoComentario' => $this->descricaoComentario,
            'idPublicacao' => $this->idPublicacao,
            'usuario' => User::find($this->idUsuario)->name,
            'idUsuario' => $this->idUsuario,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
            'avaliado' => !! AvaliacaoComentario::where('idUsuario', auth()->id())->where('idComentario', $this->idComentario)->count(),
            'avaliacoes' => AvaliacaoComentario::where('idComentario', $this->idComentario)->count()
        ];
    }
}
