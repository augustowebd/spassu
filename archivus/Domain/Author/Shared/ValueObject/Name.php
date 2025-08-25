<?php

namespace Archivus\Domain\Author\Shared\ValueObject;

use Archivus\Shared\ValueObjects\Str;

class Name extends Str
{
    public const int MIN_LENGTH = 3;
    public const int MAX_LENGTH = 40;
}
