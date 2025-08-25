<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Archivus\Domain\Book\Remove\Request;

final class RequestTest extends TestCase
{
    private const EXPECTED_ID = 1704;

    public function testCanBeInstantiated(): void
    {
        $request = new Request(self::EXPECTED_ID);

        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame(self::EXPECTED_ID, $request->id);
    }
}
