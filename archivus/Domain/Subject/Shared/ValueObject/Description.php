<?php

namespace Archivus\Domain\Subject\Shared\ValueObject;

use Archivus\Shared\ValueObjects\Str;

class Description extends Str
{
    public const int MIN_LENGTH = 0;
    public const int MAX_LENGTH = 20;
}
