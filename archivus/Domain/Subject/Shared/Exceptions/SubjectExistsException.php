<?php

namespace Archivus\Domain\Subject\Shared\Exceptions;

use Archivus\Shared\Exceptions\Traits\HasThrowsIf;
use DomainException;

class SubjectExistsException extends DomainException
{
    use HasThrowsIf;
}
