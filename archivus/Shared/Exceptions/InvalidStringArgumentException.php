<?php

declare(strict_types=1);

namespace Archivus\Shared\Exceptions;

use Archivus\Shared\Exceptions\Traits\HasThrowsIf;
use DomainException;

/**
 * @codeCoverageIgnore
 */
class InvalidStringArgumentException extends DomainException
{
    use HasThrowsIf;
}
