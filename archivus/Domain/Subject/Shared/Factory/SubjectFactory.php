<?php

namespace Archivus\Domain\Subject\Shared\Factory;

use Archivus\Domain\Subject\Subject;
use Archivus\Domain\Subject\Shared\ValueObject\Description;

class SubjectFactory
{
    public function create(string $description): Subject
    {
        return new Subject(
            id: null,
            description: Description::from($description)
        );
    }

    public function load(
        int $id,
        string $description
    ): Subject {
        return new Subject(
            id: $id,
            description: Description::from($description)
        );
    }
}
