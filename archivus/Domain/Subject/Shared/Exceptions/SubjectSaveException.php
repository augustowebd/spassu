<?php

namespace Archivus\Domain\Subject\Shared\Exceptions;

use Archivus\Shared\Exceptions\Traits\HasThrowsIf;
use DomainException;

class SubjectSaveException extends DomainException
{
    use HasThrowsIf;
}
