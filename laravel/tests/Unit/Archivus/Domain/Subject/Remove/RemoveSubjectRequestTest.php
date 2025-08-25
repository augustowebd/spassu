<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Archivus\Domain\Subject\Remove\Request;

final class RemoveSubjectRequestTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $id = 123;
        $request = new Request(id: $id);

        $this->assertSame($id, $request->id);
    }
}
