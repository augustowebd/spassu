<?php

namespace App\Infrastructure\Mappers;

use App\Models\Assunto;
use Archivus\Domain\Subject\Shared\ValueObject\Description;
use Archivus\Domain\Subject\Subject;
use Archivus\Shared\Collections\Books;

class SubjectMapper
{
    public static function toDomain(Assunto $model): Subject
    {
        $bookList = new Books;

        $model->livros()
            ?->get()
            ?->each(fn ($book) => $bookList->add(BookMapper::toDomain($book)));

        return new Subject(
            id: $model->codAs,
            description: Description::from($model->descricao),
            books: $bookList,
        );
    }
}
