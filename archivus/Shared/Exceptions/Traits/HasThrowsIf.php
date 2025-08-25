<?php

declare(strict_types=1);

namespace Archivus\Shared\Exceptions\Traits;

trait HasThrowsIf
{
    public static function throwsIf(
        bool $assert,
        string $message = "",
        ?int $code = 0
    ): void {
        $class = static::class;

        $errorMessage = defined("$class::DEFAULT_ERR_MSG") && empty($message)
            ? constant("$class::DEFAULT_ERR_MSG")
            : $message;

        $errorCode = defined("$class::DEFAULT_ERR_CODE") && empty($code)
            ? constant("$class::DEFAULT_ERR_CODE")
            : $code;

        if ($assert) {
            throw new static($errorMessage, $errorCode);
        }
    }

    public static function throwsNotIf(
        bool $assert,
        string $message = "",
        ?int $code = 0
    ): void {
        static::throwsIf(! $assert, $message, $code);
    }
}
