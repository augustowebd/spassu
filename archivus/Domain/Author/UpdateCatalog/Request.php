<?php

namespace Archivus\Domain\Author\UpdateCatalog;

use Archivus\Shared\Collections\Books;

final readonly class Request
{
    public function __construct(
        public int $authorId,
        public Books $books
    ) { ; }
}
