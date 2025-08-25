<?php

declare(strict_types=1);

use Archivus\Domain\Author\Author;
use Archivus\Domain\Author\Shared\Factory\AuthorFactory;
use Archivus\Domain\Author\Shared\ValueObject\Name;
use Archivus\Shared\Collections\Books;
use PHPUnit\Framework\TestCase;

final class AuthorFactoryTest extends TestCase
{
    public const int EXPECTED_ID = 1704;
    public const string EXPECTED_NAME = 'floquinho';
    private AuthorFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new AuthorFactory();
    }

    public function testCreateReturnsNewAuthor(): void
    {
        $author = $this->factory->create(self::EXPECTED_NAME);

        $this->assertInstanceOf(Author::class, $author);
        $this->assertNull($author->id);
        $this->assertInstanceOf(Name::class, $author->name);
        $this->assertSame(self::EXPECTED_NAME, $author->name->value);
        $this->assertNull($author->books);
    }

    public function testLoadReturnsAuthorWithIdAndBooks(): void
    {
        $books = $this->createMock(Books::class);

        $author = $this->factory->load(
            id: 42,
            name: self::EXPECTED_NAME,
            books: $books
        );

        $this->assertInstanceOf(Author::class, $author);
        $this->assertSame(42, $author->id);
        $this->assertInstanceOf(Name::class, $author->name);
        $this->assertSame(self::EXPECTED_NAME, (string)$author->name);
        $this->assertSame($books, $author->books);
    }

    public function testLoadReturnsAuthorWithNullBooks(): void
    {
        $author = $this->factory->load(
            id: 99,
            name: self::EXPECTED_NAME
        );

        $this->assertInstanceOf(Author::class, $author);
        $this->assertSame(99, $author->id);
        $this->assertNull($author->books);
    }
}
