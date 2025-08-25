<?php

namespace Database\Seeders;

use App\Models\Assunto;
use App\Models\Autor;
use App\Models\Livro;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $autores = Autor::factory(5)->create();
        $assuntos = Assunto::factory(5)->create();
        $livros = Livro::factory(1)->create();

        $livros->each(function ($livro) use ($autores, $assuntos) {
            # adiciona entre 1 e 3 autores
            $livro->autores()->attach(
                $autores->random(rand(1, 3))->pluck('codAu')->toArray()
            );

            # adiciona entre 1 e 3 autores
            $livro->assuntos()->attach(
                $assuntos->random(rand(1, 5))->pluck('codAs')->toArray()
            );
        });
    }
}
