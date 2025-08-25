<?php

namespace Tests\Unit\Archivus\Domain\Author;

use Archivus\Domain\Author\Author;
use Archivus\Domain\Author\Shared\ValueObject\Name;
use Archivus\Domain\Book\Book;
use Archivus\Shared\Collections\Books;
use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase
{
    public function test_it_removes_books_not_in_new_collection(): void
    {
        $book1 = $this->createBook(1);
        $book2 = $this->createBook(2);

        $books = new Books();
        $books->add($book1);
        $books->add($book2);

        $author = new Author(1, new Name('Machado de Assis'), $books);

        $newBooks = new Books();
        $newBooks->add($book1);
        $author->syncBooks($newBooks);

        $this->assertTrue($author->books->contains($book1));
        $this->assertFalse($author->books->contains($book2));
    }

    public function test_it_adds_new_books(): void
    {
        $book1 = $this->createBook(1);
        $book2 = $this->createBook(2);

        $author = new Author(1, new Name('Clarice Lispector'), new Books($book1));

        $newBooks = new Books($book1, $book2);

        $author->syncBooks($newBooks);

        $this->assertTrue($author->books->contains($book1));
        $this->assertTrue($author->books->contains($book2));
    }

    public function test_it_keeps_existing_books_if_present_in_new_collection(): void
    {
        $book1 = $this->createBook(1);
        $author = new Author(1, new Name('Guimarães Rosa'), new Books($book1));

        $newBooks = new Books($book1);

        $author->syncBooks($newBooks);

        $this->assertCount(1, $author->books);
        $this->assertTrue($author->books->contains($book1));
    }

    private function createBook(int $id): Book
    {
        return new class($id, 'Dummy Title', 'Dummy Publisher', '1st', 2025, 10.0) extends Book {};
    }
}
