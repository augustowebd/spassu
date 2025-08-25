<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Archivus\Shared\Exceptions\Traits\HasThrowsIf;

final class HasThrowsIfTest extends TestCase
{
    public function testThrowsIfThrowsWhenTrue(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('custom message');
        $exceptionClass = new class('') extends Exception { use HasThrowsIf; };
        $exceptionClass::throwsIf(true, 'custom message', 456);
    }

    public function testThrowsIfUsesDefaultMessageAndCode(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('default message');

        $exceptionClass = new class('') extends Exception {
            use HasThrowsIf;

            public const DEFAULT_ERR_MSG = 'default message';
            public const DEFAULT_ERR_CODE = 123;
        };

        try {
            $exceptionClass::throwsIf(true);
        } catch (Exception $e) {
            $this->assertSame(123, $e->getCode());
            throw $e;
        }
    }
}
