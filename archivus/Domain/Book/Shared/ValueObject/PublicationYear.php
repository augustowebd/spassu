<?php

namespace Archivus\Domain\Book\Shared\ValueObject;

use Archivus\Shared\ValueObjects\Str;

class PublicationYear extends Str
{
    public const int MIN_LENGTH = 4;
    public const int MAX_LENGTH = 4;
}
