<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    public function publicacao()
    {
        return $this->belongsTo(Publicacao::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function avaliacaoComentario()
    {
        return $this->hasMany(AvaliacaoComentario::class);
    }
}
