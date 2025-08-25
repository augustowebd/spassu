<?php

namespace Archivus\Domain\Author\Remove;

final readonly class Request
{
    public function __construct(
        public int $id,
    ) { ; }
}
