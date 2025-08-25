<?php

namespace App\Infrastructure\Mappers;

use App\Models\Autor;
use Archivus\Domain\Author\Author;
use Archivus\Domain\Author\Shared\Factory\AuthorFactory as Factory;
use Archivus\Shared\Collections\Books;

class AuthorMapper
{
    public static function toDomain(Autor $model): Author
    {
        $bookList = new Books;

        $model->livros()
            ?->get()
            ?->each(fn ($book) => $bookList->add(BookMapper::toDomain($book)));

        return (new Factory())->load(
            id: $model->codAu,
            name: $model->nome,
            books: $bookList,
        );
    }
}
