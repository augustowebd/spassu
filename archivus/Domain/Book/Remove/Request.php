<?php

namespace Archivus\Domain\Book\Remove;

final readonly class Request
{
    public function __construct(
        public int $id,
    ) { ; }
}
