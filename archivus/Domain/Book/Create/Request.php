<?php

namespace Archivus\Domain\Book\Create;

final readonly class Request
{
    public function __construct(
        public string $title,
        public string $publisher,
        public string $edition,
        public int $year,
        public float $price,
        public array $authorIds,
        public array $subjectIds
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            publisher: $data['publisher'],
            edition: $data['edition'],
            year: $data['year'],
            price: $data['price'],
            authorIds: $data['authorIds'] ?? [],
            subjectIds: $data['subjectIds'] ?? [],
        );
    }
}
