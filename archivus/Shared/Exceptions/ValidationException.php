<?php

declare(strict_types=1);

namespace Archivus\Shared\Exceptions;

use DomainException;
use Archivus\Shared\Exceptions\Traits\HasThrowsIf;

/**
 * @codeCoverageIgnore
 */
class ValidationException extends DomainException
{
    use HasThrowsIf;

    protected $message = '%s_INVALID';

    /**
     * @throws DomainException
     */
    public function __construct(string $message)
    {
        throw empty($message)
            ? parent::__construct(code: 422)
            : parent::__construct(message: sprintf($this->message, $message), code: 422);
    }
}
