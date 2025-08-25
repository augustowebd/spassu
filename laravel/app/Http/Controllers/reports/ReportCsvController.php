<?php

namespace App\Http\Controllers\reports;

use App\Models\VwLivroAutor;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportCsvController extends Controller
{
    public function __invoke(): StreamedResponse
    {
        $authors = VwLivroAutor::orderBy('autor_nome')->get();
        $filename = "relatorio_autores.csv";

        $headers = [
            "Content-Type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($authors) {
            $handle = fopen('php://output', 'w');

            // BOM UTF-8 para Excel
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Cabeçalho CSV (ponto e vírgula)
            fputcsv($handle, [
                'Autor',
                'Livro',
                'Editora',
                'Edição',
                'Ano Publicação',
                'Preço',
                'Assuntos',
            ], ';');

            foreach ($authors as $autor) {
                $books = is_array($autor->livros) ? $autor->livros : json_decode($autor->livros, true);
                if (!$books) $books = [];

                $firstLine = true; // controla repetição do nome do autor

                foreach ($books as $book) {
                    fputcsv($handle, [
                        $firstLine ? $autor->autor_nome : '',
                        $book['titulo'] ?? '',
                        $book['editora'] ?? '',
                        $book['edicao'] ?? '',
                        $book['anoPublicacao'] ?? '',
                        isset($book['preco']) ? number_format($book['preco'], 2, ',', '.') : '',
                        !empty($book['assuntos'])
                            ? implode(', ', array_column($book['assuntos'], 'descricao'))
                            : 'Sem assuntos',
                    ], ';');

                    $firstLine = false;
                }

                if (empty($books)) {
                    fputcsv($handle, [
                        $autor->autor_nome,
                        '', '', '', '', '', ''
                    ], ';');
                }
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
