<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Archivus\Domain\Book\Shared\ValueObject\Publisher;
use Archivus\Shared\Exceptions\InvalidStringArgumentException;

final class PublisherTest extends TestCase
{
    #[DataProvider('validPublisherProvider')]
    public function testConstructorAcceptsValidPublisher(string $name): void
    {
        $publisher = new Publisher($name);
        $this->assertSame($name, $publisher->value);
    }

    public static function validPublisherProvider(): array
    {
        return [
            ['Editora Alfa'],
            ['B'],
            [str_repeat('a', 40)],
        ];
    }

    #[DataProvider('invalidPublisherProvider')]
    public function testConstructorThrowsExceptionForInvalidPublisher(string $name): void
    {
        $this->expectException(InvalidStringArgumentException::class);
        $this->expectExceptionMessage('expected string with min: 1, max: 40 characters');

        new Publisher($name);
    }

    public static function invalidPublisherProvider(): array
    {
        return [
            [''],
            [str_repeat('a', 41)],
        ];
    }

    public function testToStringAndMagicToString(): void
    {
        $publisher = new Publisher('Pearson');
        $this->assertSame('Pearson', $publisher->toString());
        $this->assertSame('Pearson', (string)$publisher);
    }

    public function testSlugMethod(): void
    {
        $publisher = new Publisher('Editora Alfa & Beta');
        $this->assertSame('editora-alfa-beta', $publisher->slug());
    }

    public function testIsEmptyMethod(): void
    {
        $publisher = new Publisher('Editora Alfa');
        $this->assertFalse($publisher->isEmpty());
    }

    public function testFromWithTruncate(): void
    {
        $publisher = Publisher::from(str_repeat('a', 50), 40);
        $this->assertSame(40, strlen($publisher->value));
    }

    public function testIfNotEmptyReturnsInstanceOrNull(): void
    {
        $publisher = Publisher::ifNotEmpty('Editora Alfa');
        $this->assertInstanceOf(Publisher::class, $publisher);

        $nullPublisher = Publisher::ifNotEmpty('');
        $this->assertNull($nullPublisher);
    }
}
