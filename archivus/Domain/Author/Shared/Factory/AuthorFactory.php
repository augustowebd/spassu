<?php

namespace Archivus\Domain\Author\Shared\Factory;

use Archivus\Domain\Author\Author;
use Archivus\Domain\Author\Shared\ValueObject\Name;
use Archivus\Shared\Collections\Books;

class AuthorFactory
{
    public function create(
        string $name
    ): Author {
        return new Author(
            id: null,
            name: Name::from($name),
            books: null,
        );
    }

    public function load(
        int $id,
        string $name,
        Books $books = null,
    ): Author {
        return new Author(
            id: $id,
            name: Name::from($name),
            books: $books,
        );
    }
}
