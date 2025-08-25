<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Archivus\Shared\ValueObjects\Str;
use Archivus\Shared\Exceptions\InvalidStringArgumentException;

class FakeStr extends Str {}

final class StrTest extends TestCase
{
    private function createStrInstance(string $value): Str
    {
        return new class($value) extends Str {};
    }

    public function testConstructorAcceptsValidString(): void
    {
        $str = $this->createStrInstance('Hello World');

        $this->assertSame('Hello World', $str->value);
    }

    public function testConstructorThrowsExceptionForEmptyString(): void
    {
        $this->expectException(InvalidStringArgumentException::class);
        $this->expectExceptionMessage('expected string with min: 2, max: 100 characters');

        $this->createStrInstance('');
    }

    public function testConstructorThrowsExceptionForTooShortString(): void
    {
        $this->expectException(InvalidStringArgumentException::class);
        $this->createStrInstance('a');
    }

    public function testConstructorThrowsExceptionForTooLongString(): void
    {
        $this->expectException(InvalidStringArgumentException::class);
        $this->createStrInstance(str_repeat('a', 101));
    }

    public function testSlugMethod(): void
    {
        $str = $this->createStrInstance('Olá Mundo PHP!');
        $this->assertSame('olá-mundo-php', $str->slug());
    }

    public function testIsEmptyMethod(): void
    {
        $str = $this->createStrInstance('Not Empty');
        $this->assertFalse($str->isEmpty());

        $this->expectException(InvalidStringArgumentException::class);
        $this->expectExceptionMessage('expected string with min: 2, max: 100 characters');

        $this->createStrInstance('  ');
    }

    public function testToStringAndMagicToString(): void
    {
        $str = $this->createStrInstance('Hello');

        $this->assertSame('Hello', $str->toString());
        $this->assertSame('Hello', (string) $str);
    }

    public function testToStringTruncated(): void
    {
        $faker = FakeStr::from('abcde', 3);
        $this->assertSame('abc', $faker->toString());
    }

    public function testCreateStringIfValueIsNotEmpty(): void
    {
        $notNull = FakeStr::ifNotEmpty('abcde');
        $isNull = FakeStr::ifNotEmpty('');

        $this->assertSame('abcde', $notNull->value);
        $this->isEmpty($isNull);
    }
}
