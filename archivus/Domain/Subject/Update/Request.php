<?php

namespace Archivus\Domain\Subject\Update;

use Archivus\Domain\Subject\Shared\ValueObject\Description;

final readonly class Request
{
    public function __construct(
        public int $id,
        public Description $description,
    ) { ; }

    public static function fromArray(mixed $data): Request
    {
        return new self(
            id: $data['id'],
            description: Description::from($data['description']),
        );
    }
}
