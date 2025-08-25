<?php

declare(strict_types=1);

use Archivus\Domain\Author\Create\Request;
use Archivus\Domain\Author\Shared\ValueObject\Name;
use Archivus\Shared\Exceptions\InvalidStringArgumentException;
use PHPUnit\Framework\TestCase;

final class CreateRequestTest extends TestCase
{
    public const string EXPECTED_NAME = 'floquinho';

    public function testCanBeInstantiatedWithConstructor(): void
    {
        $request = new Request(name: Name::from(self::EXPECTED_NAME));

        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame(self::EXPECTED_NAME, $request->name->value);
    }

    public function testCanBeInstantiatedFromArray(): void
    {
        $data = ['name' => self::EXPECTED_NAME];

        $request = Request::fromArray($data);

        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame(self::EXPECTED_NAME, $request->name->value);
    }

    public function testFromArrayThrowsExceptionWhenNameIsMissing(): void
    {
        $this->expectException(InvalidStringArgumentException::class);
        $this->expectExceptionMessage('expected string with min: 3, max: 40 characters');

        Request::fromArray([]);
    }
}
