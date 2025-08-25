<?php

namespace Archivus\Domain\Book\Update;

use App\Helpers\CurrencyHelper;

final readonly class Request
{
    public function __construct(
        public int $id,
        public string $title,
        public string $publisher,
        public string $edition,
        public int $year,
        public float $price,
        public array $authorIds,
        public array $subjectIds
    ) { ; }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            title: $data['title'],
            publisher: $data['publisher'],
            edition: $data['edition'],
            year: $data['year'],
            price: CurrencyHelper::brlToDecimal($data['price']),
            authorIds: $data['authorIds'] ?? [],
            subjectIds: $data['subjectIds'] ?? [],
        );
    }
}
