<?php

namespace Archivus\Domain\Book\Shared\Exceptions;

use Archivus\Shared\Exceptions\Traits\HasThrowsIf;
use DomainException;

class BookRemoveException extends DomainException
{
    use HasThrowsIf;
}
