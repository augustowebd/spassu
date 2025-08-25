<?php

declare(strict_types=1);

use Archivus\Domain\Author\Shared\ValueObject\Name;
use Archivus\Shared\Exceptions\InvalidStringArgumentException;
use PHPUnit\Framework\TestCase;

final class NameTest extends TestCase
{
    public function testCanBeCreatedWithValidString(): void
    {
        $name = Name::from('Floquinho');

        $this->assertInstanceOf(Name::class, $name);
        $this->assertSame('Floquinho', (string)$name);
    }

    public function testThrowsExceptionWhenTooShort(): void
    {
        $this->expectException(InvalidStringArgumentException::class);

        Name::from('ab');
    }

    public function testTruncatesStringExceedingMaxLength(): void
    {
        $longName = str_repeat('_', 41);
        $name = Name::from($longName);

        $this->assertSame(40, strlen((string)$name));
        $this->assertSame(str_repeat('_', 40), (string)$name);
    }

    public function testMinAndMaxLengthConstants(): void
    {
        $this->assertSame(3, Name::MIN_LENGTH);
        $this->assertSame(40, Name::MAX_LENGTH);
    }
}
