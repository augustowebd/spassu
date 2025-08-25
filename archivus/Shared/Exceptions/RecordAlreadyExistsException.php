<?php

declare(strict_types=1);

namespace Archivus\Shared\Exceptions;

use DomainException;
use Archivus\Shared\Exceptions\Traits\HasThrowsIf;

/**
 * @codeCoverageIgnore
 */
class RecordAlreadyExistsException extends DomainException
{
    use HasThrowsIf;

    const DEFAULT_ERR_CODE = 409;
}
