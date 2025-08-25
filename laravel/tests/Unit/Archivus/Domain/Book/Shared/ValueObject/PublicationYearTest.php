<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Archivus\Domain\Book\Shared\ValueObject\PublicationYear;
use Archivus\Shared\Exceptions\InvalidStringArgumentException;

final class PublicationYearTest extends TestCase
{
    public function testConstructorAcceptsValidYear(): void
    {
        $year = new PublicationYear('2025');
        $this->assertSame('2025', $year->value);
    }

    public function testConstructorThrowsExceptionForTooShortYear(): void
    {
        $this->expectException(InvalidStringArgumentException::class);
        new PublicationYear('123');
    }

    public function testConstructorThrowsExceptionForTooLongYear(): void
    {
        $this->expectException(InvalidStringArgumentException::class);
        new PublicationYear('12345');
    }

    public function testConstructorThrowsExceptionForEmptyString(): void
    {
        $this->expectException(InvalidStringArgumentException::class);
        new PublicationYear('');
    }

    public function testToStringAndMagicToString(): void
    {
        $year = new PublicationYear('2025');
        $this->assertSame('2025', $year->toString());
        $this->assertSame('2025', (string)$year);
    }

    public function testSlugMethod(): void
    {
        $year = new PublicationYear('2025');
        $this->assertSame('2025', $year->slug());
    }

    public function testIsEmptyMethod(): void
    {
        $year = new PublicationYear('2025');
        $this->assertFalse($year->isEmpty());
    }

    public function testFromWithTruncate(): void
    {
        $year = PublicationYear::from('20256', 4);
        $this->assertSame('2025', $year->value);
    }

    public function testIfNotEmptyReturnsInstanceOrNull(): void
    {
        $year = PublicationYear::ifNotEmpty('2025');
        $this->assertInstanceOf(PublicationYear::class, $year);

        $nullYear = PublicationYear::ifNotEmpty('');
        $this->assertNull($nullYear);
    }
}
