<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const string DDL_VIEW = <<< _
CREATE OR REPLACE VIEW vw_livros_por_autor AS
SELECT 
    a."codAu"    AS autor_id,
    a.nome       AS autor_nome,
    COUNT(l.codl) AS total_livros,
    json_agg(
        json_build_object(
            'livro_id', l.codl,
            'titulo', l.titulo,
            'editora', l.editora,
            'edicao', l.edicao,
            'anoPublicacao', l."anoPublicacao",
            'preco', l.preco,
            'assuntos', (
                SELECT json_agg(json_build_object('assunto_id', s."codAs", 'descricao', s.descricao))
                FROM livro_assunto ls
                JOIN assuntos s ON ls."assunto_codAs" = s."codAs"
                WHERE ls.livro_codl = l.codl
            )
        )
    ) AS livros
FROM autores a
JOIN livro_autor la ON a."codAu" = la."autor_codAu"
JOIN livros l ON la.livro_codl = l.codl
GROUP BY a."codAu", a.nome
ORDER BY a.nome
_;

    public function up(): void
    {
        DB::statement(self::DDL_VIEW);
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vw_livros_por_autor');
    }
};
