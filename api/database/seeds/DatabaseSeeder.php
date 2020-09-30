<?php

use App\Model\AvaliacaoComentario;
use App\Model\Categoria;
use App\Model\Comentario;
use App\Model\Publicacao;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(User::class, 10)->create();
        factory(Categoria::class, 5)->create();
        factory(Publicacao::class, 10)->create();
        factory(Comentario::class, 50)->create()->each(function () {
            return factory(AvaliacaoComentario::class, 2)->create();
        });
    }
}
