<?php

namespace Archivus\Domain\Book;

use Archivus\Domain\Author\Author;
use Archivus\Domain\Subject\Subject;

class Book
{
    public function __construct(
        public ?int $id,
        public string $title,
        public string $publisher,
        public string $edition,
        public int $year,
        public float $price,
        public array $authors = [],
        public array $subjects = [],
    ) { ; }

    public function addAuthor(Author $author): void
    {
        $this->authors[] = $author;
    }

    public function addSubject(Subject $subject): void
    {
        $this->subjects[] = $subject;
    }
}
