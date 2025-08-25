<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livro_autor', function (Blueprint $table) {
            $table->unsignedBigInteger('livro_codl');
            $table->unsignedBigInteger('autor_codAu');
            $table->primary(['livro_codl', 'autor_codAu']);

            $table->foreign('livro_codl')->references('codl')->on('livros')->onDelete('cascade');
            $table->foreign('autor_codAu')->references('codAu')->on('autores')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livro_autor');
    }
};
