<?php

namespace Archivus\Domain\Subject\Remove;

final readonly class Request
{
    public function __construct(
        public int $id,
    ) { ; }
}
