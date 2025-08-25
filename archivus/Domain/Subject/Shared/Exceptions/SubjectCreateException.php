<?php

namespace Archivus\Domain\Subject\Shared\Exceptions;

use Archivus\Shared\Exceptions\Traits\HasThrowsIf;
use DomainException;

class SubjectCreateException extends DomainException
{
    use HasThrowsIf;
}
