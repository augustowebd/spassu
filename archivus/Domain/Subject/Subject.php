<?php

namespace Archivus\Domain\Subject;

use Archivus\Domain\Subject\Shared\ValueObject\Description;
use Archivus\Shared\Collections\Books;

class Subject
{
    public function __construct(
        public ?int $id,
        public Description $description,
        public ?Books $books = null,
    ) { ; }
}
