<?php

namespace Archivus\Domain\Book\Shared\ValueObject;

use Archivus\Shared\ValueObjects\Str;

class Edition extends Str
{
    public const int MIN_LENGTH = 1;
    public const int MAX_LENGTH = 40;
}
