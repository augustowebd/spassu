<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Archivus\Domain\Book\Shared\ValueObject\Edition;
use Archivus\Shared\Exceptions\InvalidStringArgumentException;

final class EditionTest extends TestCase
{
    public function testConstructorAcceptsValidString(): void
    {
        $edition = new Edition('Primeira Edição');

        $this->assertSame('Primeira Edição', $edition->value);
    }

    public function testConstructorThrowsExceptionForEmptyString(): void
    {
        $this->expectException(InvalidStringArgumentException::class);
        new Edition('');
    }

    public function testConstructorThrowsExceptionForTooShortString(): void
    {
        $this->expectException(InvalidStringArgumentException::class);
        new Edition('');
    }

    public function testConstructorThrowsExceptionForTooLongString(): void
    {
        $this->expectException(InvalidStringArgumentException::class);
        new Edition(str_repeat('a', 41));
    }

    public function testSlugMethod(): void
    {
        $edition = new Edition('Edição Especial!');
        $this->assertSame('edição-especial', $edition->slug());
    }

    public function testIsEmptyMethod(): void
    {
        $edition = new Edition('Regular');
        $this->assertFalse($edition->isEmpty());
    }

    public function testToStringAndMagicToString(): void
    {
        $edition = new Edition('Segunda');
        $this->assertSame('Segunda', $edition->toString());
        $this->assertSame('Segunda', (string) $edition);
    }

    public function testFromWithTruncate(): void
    {
        $edition = Edition::from('Uma Edição Muito Longa', 5);
        $this->assertSame('Uma E', $edition->value);
    }

    public function testIfNotEmptyReturnsInstanceOrNull(): void
    {
        $edition = Edition::ifNotEmpty('Especial');
        $this->assertInstanceOf(Edition::class, $edition);

        $nullEdition = Edition::ifNotEmpty('');
        $this->assertNull($nullEdition);
    }
}
