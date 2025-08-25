<?php

namespace Archivus\Domain\Author\Shared\Exceptions;

use Archivus\Shared\Exceptions\Traits\HasThrowsIf;
use DomainException;

class AuthorExistsException extends DomainException
{
    use HasThrowsIf;
}
