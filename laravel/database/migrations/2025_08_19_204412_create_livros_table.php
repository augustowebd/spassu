<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->id('codl');
            $table->string('titulo', 40)->index();
            $table->string('editora', 40)->index();
            $table->integer('edicao');
            $table->string('anoPublicacao', 4);
            $table->decimal('preco', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};
