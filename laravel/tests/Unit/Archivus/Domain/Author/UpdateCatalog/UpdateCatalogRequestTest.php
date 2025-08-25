<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Archivus\Domain\Author\UpdateCatalog\Request;
use Archivus\Shared\Collections\Books;
use Archivus\Domain\Book\Book;

final class UpdateCatalogRequestTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $book1 = new Book(
            id: 1,
            title: 'Book One',
            publisher: 'Publisher A',
            edition: '1st',
            year: 2024,
            price: 29.9
        );

        $book2 = new Book(
            id: 2,
            title: 'Book Two',
            publisher: 'Publisher B',
            edition: '2nd',
            year: 2025,
            price: 39.9
        );

        $books = new Books($book1, $book2);

        $request = new Request(authorId: 1001, books: $books);

        $this->assertSame(1001, $request->authorId);
        $this->assertSame($books, $request->books);
        $this->assertCount(2, iterator_to_array($request->books));
    }
}
