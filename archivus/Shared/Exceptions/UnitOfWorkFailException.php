<?php

declare(strict_types=1);

namespace Archivus\Shared\Exceptions;

use DomainException;
use Archivus\Shared\Exceptions\Traits\HasThrowsIf;

/**
 * @codeCoverageIgnore
 */
class UnitOfWorkFailException extends DomainException
{
    use HasThrowsIf;
}
