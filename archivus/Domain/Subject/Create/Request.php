<?php

namespace Archivus\Domain\Subject\Create;

use Archivus\Domain\Subject\Shared\ValueObject\Description;

final readonly class Request
{
    public function __construct(
        public Description $description,
    ) { ; }

    public static function fromArray(mixed $data): Request
    {
        return new self(
            description: Description::from($data['description'] ?? ''),
        );
    }
}
