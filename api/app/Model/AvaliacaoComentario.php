<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AvaliacaoComentario extends Model
{
    protected $table = 'avaliacao_comentario';
    protected $primaryKey = 'idAvaliacaoComentario';
    protected $guarded = [];
}
