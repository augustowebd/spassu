<?php

declare(strict_types=1);

use Archivus\Domain\Author\Remove\Request;
use PHPUnit\Framework\TestCase;

final class RemoveRequestTest extends TestCase
{
    public const int EXPECTED_ID = 1704;

    public function testCanBeInstantiatedWithConstructor(): void
    {
        $this->assertSame(
            self::EXPECTED_ID,
            (new Request(id: self::EXPECTED_ID))->id
        );
    }
}
