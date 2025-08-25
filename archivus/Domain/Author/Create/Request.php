<?php

namespace Archivus\Domain\Author\Create;

use Archivus\Domain\Author\Shared\ValueObject\Name;

final readonly class Request
{
    public function __construct(public Name $name)
    { ; }

    public static function fromArray(array $data): self
    {
        return new self(
            name: Name::from($data['name'] ?? ''),
        );
    }
}
