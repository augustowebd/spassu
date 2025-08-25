<?php

namespace Archivus\Domain\Author\Shared\Exceptions;

use Archivus\Shared\Exceptions\Traits\HasThrowsIf;
use DomainException;

class AuthorSaveException extends DomainException
{
    use HasThrowsIf;
}
