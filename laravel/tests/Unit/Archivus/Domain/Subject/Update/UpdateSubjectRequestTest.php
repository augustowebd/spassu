<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Archivus\Domain\Subject\Update\Request;
use Archivus\Domain\Subject\Shared\ValueObject\Description;

final class UpdateSubjectRequestTest extends TestCase
{
    public function testConstructorAssignsProperties(): void
    {
        $description = new Description('Matemática');
        $request = new Request(1, $description);

        $this->assertSame(1, $request->id);
        $this->assertSame($description, $request->description);
    }

    public function testFromArrayCreatesInstance(): void
    {
        $data = [
            'id' => 10,
            'description' => 'Física'
        ];

        $request = Request::fromArray($data);

        $this->assertSame(10, $request->id);
        $this->assertInstanceOf(Description::class, $request->description);
        $this->assertSame('Física', $request->description->value);
    }
}
