<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Archivus\Domain\Subject\Create\Request;
use Archivus\Domain\Subject\Shared\ValueObject\Description;
use Archivus\Shared\Exceptions\InvalidStringArgumentException;

final class CreateSubjectRequestTest extends TestCase
{
    private const VALID_DESCRIPTION = 'Matemática';

    public function testCanBeInstantiatedWithConstructor(): void
    {
        $description = Description::from(self::VALID_DESCRIPTION);
        $request = new Request(description: $description);

        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame(self::VALID_DESCRIPTION, $request->description->value);
    }

    public function testCanBeInstantiatedFromArray(): void
    {
        $data = ['description' => self::VALID_DESCRIPTION];
        $request = Request::fromArray($data);

        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame(self::VALID_DESCRIPTION, $request->description->value);
    }

    public function testFromArrayThrowsExceptionWhenDescriptionMissing(): void
    {
        $this->expectException(InvalidStringArgumentException::class);

        Request::fromArray([]);
    }
}
