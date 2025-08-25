<?php

namespace Archivus\Domain\Subject\Shared\Exceptions;

use Archivus\Shared\Exceptions\Traits\HasThrowsIf;
use DomainException;

class CannotDeleteAuthorWithBooksException extends DomainException
{
    use HasThrowsIf;
}
