<?php

declare(strict_types=1);

namespace Archivus\Shared\ValueObjects;

use Archivus\Shared\Exceptions\InvalidStringArgumentException;

abstract class Str implements Stringable
{
    public const MIN_LENGTH = 2;
    public const MAX_LENGTH = 100;

    public function __construct(public string $value)
    {
        $this->value  = trim($value);
        $length = mb_strlen($this->value);

        InvalidStringArgumentException::throwsIf(
            empty($this->value) ||
            $length < static::MIN_LENGTH ||
            $length > static::MAX_LENGTH,
            sprintf(
                'expected string with min: %d, max: %d characters',
                static::MIN_LENGTH,
                static::MAX_LENGTH
            )
        );
    }

    public function slug(): string
    {
        $slug = mb_strtolower($this->value);
        $slug = preg_replace('/[^\p{L}\p{N}]+/u', '-', $slug);
        $slug = trim($slug, '-');

        return $slug;
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public static function from(string $value, int $truncateAt = null): static
    {

        if (null != $truncateAt) {
            $truncateAt = $truncateAt <= static::MAX_LENGTH ? $truncateAt : static::MIN_LENGTH;
        } else {
            $truncateAt = static::MAX_LENGTH;
        }

        $value = trim($value);
        $value = substr($value,0, $truncateAt);

        return new static($value);
    }

    public static function ifNotEmpty(string $value): ?static
    {
        if (empty($value)) {
            return null;
        }

        return new static($value);
    }
}
