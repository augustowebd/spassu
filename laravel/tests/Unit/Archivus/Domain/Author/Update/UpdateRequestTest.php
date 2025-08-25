<?php

declare(strict_types=1);

use Archivus\Domain\Author\Shared\ValueObject\Name;
use Archivus\Domain\Author\Update\Request;
use Archivus\Shared\Exceptions\InvalidStringArgumentException;
use PHPUnit\Framework\TestCase;

final class UpdateRequestTest extends TestCase
{
    private const EXPECTED_ID = 42;
    private const EXPECTED_NAME = 'Floquinho';

    public function testCanBeInstantiatedWithConstructor(): void
    {
        $request = new Request(
            id: self::EXPECTED_ID,
            name: Name::from(self::EXPECTED_NAME)
        );

        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame(self::EXPECTED_ID, $request->id);
        $this->assertSame(self::EXPECTED_NAME, Name::from(self::EXPECTED_NAME)->value);
    }

    public function testCanBeInstantiatedFromArray(): void
    {
        $data = [
            'id' => self::EXPECTED_ID,
            'name' => self::EXPECTED_NAME,
        ];

        $request = Request::fromArray($data);

        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame(self::EXPECTED_ID, $request->id);
        $this->assertSame(self::EXPECTED_NAME, Name::from(self::EXPECTED_NAME)->value);
    }

    public function testFromArrayThrowsExceptionWhenDataIsMissing(): void
    {
        $this->expectException(InvalidStringArgumentException::class);

        Request::fromArray(['id' => null, 'name' => null]);
    }
}
