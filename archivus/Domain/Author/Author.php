<?php

namespace Archivus\Domain\Author;

use Archivus\Domain\Author\Shared\ValueObject\Name;
use Archivus\Shared\Collections\Books;

class Author
{
    public function __construct(
        public ?int $id,
        public Name $name,
        public ?Books $books = null,
    ) { ; }

    public function syncBooks(Books $newBooks): void
    {
        foreach ($this->books as $book) {
            if (! $newBooks->contains($book)) {
                $this->books->remove($book);
            }
        }

        foreach ($newBooks as $book) {
            if (! $this->books->contains($book)) {
                $this->books->add($book);
            }
        }
    }
}
