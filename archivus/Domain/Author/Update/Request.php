<?php

namespace Archivus\Domain\Author\Update;

use Archivus\Domain\Author\Shared\ValueObject\Name;

readonly class Request
{
    public function __construct(
        public int $id,
        public Name $name,
    ) { ; }

    public static function fromArray(array $data): Request
    {
        return new self(
            id: $data['id'] ?: 0,
            name: Name::from($data['name'] ?: ''),
        );
    }
}
