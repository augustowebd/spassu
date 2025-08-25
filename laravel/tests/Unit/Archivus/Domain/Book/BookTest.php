<?php

declare(strict_types=1);

use Archivus\Domain\Author\Author;
use Archivus\Domain\Author\Shared\ValueObject\Name;
use Archivus\Domain\Book\Book;
use Archivus\Domain\Subject\Shared\ValueObject\Description;
use Archivus\Domain\Subject\Subject;
use PHPUnit\Framework\TestCase;

final class BookTest extends TestCase
{
    public function testConstructorSetsPropertiesCorrectly(): void
    {
        $book = new Book(
            id: 1,
            title: 'Test Title',
            publisher: 'Test Publisher',
            edition: '1st',
            year: 2025,
            price: 49.9
        );

        $this->assertSame(1, $book->id);
        $this->assertSame('Test Title', $book->title);
        $this->assertSame('Test Publisher', $book->publisher);
        $this->assertSame('1st', $book->edition);
        $this->assertSame(2025, $book->year);
        $this->assertSame(49.9, $book->price);
        $this->assertSame([], $book->authors);
        $this->assertSame([], $book->subjects);
    }

    public function testAddAuthorAddsAuthorToAuthorsArray(): void
    {
        $book = new Book(
            id: 1,
            title: 'Test Title',
            publisher: 'Test Publisher',
            edition: '1st',
            year: 2025,
            price: 49.9
        );

        $author = new Author(id: 1, name: new Name('Author Name'));
        $book->addAuthor($author);

        $this->assertCount(1, $book->authors);
        $this->assertSame($author, $book->authors[0]);
    }

    public function testAddSubjectAddsSubjectToSubjectsArray(): void
    {
        $book = new Book(
            id: 1,
            title: 'Test Title',
            publisher: 'Test Publisher',
            edition: '1st',
            year: 2025,
            price: 49.9
        );

        $subject = new Subject(
            id: 1,
            description: Description::from('Subject Name')
        );
        $book->addSubject($subject);

        $this->assertCount(1, $book->subjects);
        $this->assertSame($subject, $book->subjects[0]);
    }

    public function testAddMultipleAuthorsAndSubjects(): void
    {
        $book = new Book(
            id: 2,
            title: 'Another Book',
            publisher: 'Publisher X',
            edition: '2nd',
            year: 2024,
            price: 59.9
        );

        $author1 = new Author(id: 1, name: new Name('Author One'));
        $author2 = new Author(id: 2, name: new Name('Author Two'));
        $subject1 = new Subject(id: 1, description: Description::from('Subject One'));
        $subject2 = new Subject(id: 2, description: Description::from('Subject Two'));

        $book->addAuthor($author1);
        $book->addAuthor($author2);
        $book->addSubject($subject1);
        $book->addSubject($subject2);

        $this->assertCount(2, $book->authors);
        $this->assertSame($author1, $book->authors[0]);
        $this->assertSame($author2, $book->authors[1]);

        $this->assertCount(2, $book->subjects);
        $this->assertSame($subject1, $book->subjects[0]);
        $this->assertSame($subject2, $book->subjects[1]);
    }
}
