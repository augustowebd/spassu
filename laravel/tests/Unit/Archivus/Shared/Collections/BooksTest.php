<?php

use Archivus\Domain\Book\Book;
use Archivus\Shared\Collections\Books;
use PHPUnit\Framework\TestCase;

class BooksTest extends TestCase
{
    private function makeBook(string $id): Book
    {
        // Mock simples para Book, já que a classe não foi detalhada
        $book = $this->createMock(Book::class);
        $book->id = $id;
        return $book;
    }

    public function testStartsEmpty()
    {
        $books = new Books();
        $this->assertTrue($books->isEmpty());
        $this->assertSame(0, $books->count());
    }

    public function testCanBeInitializedWithBooks()
    {
        $book1 = $this->makeBook('1');
        $book2 = $this->makeBook('2');

        $books = new Books($book1, $book2);

        $this->assertFalse($books->isEmpty());
        $this->assertSame(2, $books->count());
    }

    public function testAddBook()
    {
        $books = new Books();
        $book = $this->makeBook('1');

        $books->add($book);

        $this->assertFalse($books->isEmpty());
        $this->assertSame(1, $books->count());
        $this->assertTrue($books->contains($book));
    }

    public function testDoesNotAddDuplicateBook()
    {
        $books = new Books();
        $book = $this->makeBook('1');

        $books->add($book);
        $books->add($book);

        $this->assertSame(1, $books->count());
    }

    public function testRemoveBook()
    {
        $book1 = $this->makeBook('1');
        $book2 = $this->makeBook('2');

        $books = new Books($book1, $book2);

        $books->remove($book1);

        $this->assertFalse($books->contains($book1));
        $this->assertTrue($books->contains($book2));
        $this->assertSame(1, $books->count());
    }

    public function testIteratorReturnsBooks()
    {
        $book1 = $this->makeBook('1');
        $book2 = $this->makeBook('2');

        $books = new Books($book1, $book2);

        $collected = [];
        foreach ($books as $book) {
            $collected[] = $book;
        }

        $this->assertCount(2, $collected);
        $this->assertSame([$book1, $book2], $collected);
    }
}
