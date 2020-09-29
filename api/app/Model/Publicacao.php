<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Publicacao extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comentario()
    {
        return $this->hasMany(Comentario::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
