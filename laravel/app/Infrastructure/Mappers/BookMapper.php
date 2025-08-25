<?php

namespace App\Infrastructure\Mappers;

use App\Models\Livro as Model;
use Archivus\Domain\Book\Book;

class BookMapper
{
    public static function toDomain(Model $model): Book
    {
        return new Book(
            id: $model->codl,
            title: $model->titulo,
            publisher: $model->editora,
            edition: $model->edicao,
            year: $model->anoPublicacao,
            price: $model->preco,
            authors: $model->autores()->pluck('codAu')->toArray(),
            subjects: $model->assuntos()->pluck('codAs')->toArray(),
        );
    }

    public static function toRepository(Book $book): array
    {
        return [
            'codl' => $book->id ?? null,
            'titulo' => $book->title,
            'editora' => $book->publisher,
            'edicao' => $book->edition,
            'anoPublicacao' => $book->year,
            'preco' => $book->price,
        ];
    }
}
