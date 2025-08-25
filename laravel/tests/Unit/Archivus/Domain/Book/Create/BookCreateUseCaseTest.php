<?php

declare(strict_types=1);

use Archivus\Domain\Author\Shared\ValueObject\Name;
use Archivus\Domain\Subject\Shared\ValueObject\Description;
use PHPUnit\Framework\TestCase;
use Archivus\Domain\Book\Create\UseCase;
use Archivus\Domain\Book\Create\Request;
use Archivus\Domain\Book\Book;
use Archivus\Domain\Book\RepositoryInterface as BookRepository;
use Archivus\Domain\Author\RepositoryInterface as AuthorRepository;
use Archivus\Domain\Subject\RepositoryInterface as SubjectRepository;
use Archivus\Domain\Author\Author;
use Archivus\Domain\Subject\Subject;

final class BookCreateUseCaseTest extends TestCase
{
    private BookRepository $bookRepo;
    private AuthorRepository $authorRepo;
    private SubjectRepository $subjectRepo;
    private UseCase $useCase;

    protected function setUp(): void
    {
        $this->bookRepo = $this->createMock(BookRepository::class);
        $this->authorRepo = $this->createMock(AuthorRepository::class);
        $this->subjectRepo = $this->createMock(SubjectRepository::class);

        $this->useCase = new UseCase(
            repository: $this->bookRepo,
            authorRepo: $this->authorRepo,
            subjectRepo: $this->subjectRepo,
        );
    }

    public function testExecuteCreatesBookWithRegisteredAuthorsAndSubjects(): void
    {
        $author1 = new Author(id: 1, name: new Name('Author 1'));
        $author2 = new Author(id: 2, name: new Name('Author 2'));

        $subject1 = new Subject(id: 10, description: Description::from('Subject 1'));
        $subject2 = new Subject(id: 20, description: Description::from('Subject 2'));

        $dto = new Request(
            title: 'Book Title',
            publisher: 'Publisher Name',
            edition: '1st',
            year: 2025,
            price: 49.9,
            authorIds: [1, 2],
            subjectIds: [10, 20]
        );

        $this->authorRepo->method('find')->willReturnMap([
            [1, $author1],
            [2, $author2],
        ]);

        $this->subjectRepo->method('find')->willReturnMap([
            [10, $subject1],
            [20, $subject2],
        ]);

        $expectedBook = new Book(
            id: null,
            title: 'Book Title',
            publisher: 'Publisher Name',
            edition: '1st',
            year: 2025,
            price: 49.9,
            authors: [$author1, $author2],
            subjects: [$subject1, $subject2]
        );

        $this->bookRepo
            ->expects($this->once())
            ->method('save')
            ->with($this->callback(fn(Book $book) =>
                $book->title === $expectedBook->title &&
                $book->authors === $expectedBook->authors &&
                $book->subjects === $expectedBook->subjects
            ))
            ->willReturn($expectedBook);

        $result = $this->useCase->execute($dto);

        $this->assertSame($expectedBook, $result);
    }

    public function testOnlyRegisteredAuthorsReturnsAuthors(): void
    {
        $author = new Author(id: 1, name: new Name('Author'));
        $dto = new Request(
            title: '',
            publisher: '',
            edition: '',
            year: 0,
            price: 0,
            authorIds: [1],
            subjectIds: []
        );

        $this->authorRepo->method('find')->with(1)->willReturn($author);

        $authors = $this->useCase->onlyRegisteredAuthors($dto);
        $this->assertSame([$author], $authors);
    }

    public function testOnlyRegisteredSubjectsReturnsSubjects(): void
    {
        $subject = new Subject(id: 1, description: Description::from('Subject'));
        $dto = new Request(
            title: '',
            publisher: '',
            edition: '',
            year: 0,
            price: 0,
            authorIds: [],
            subjectIds: [1]
        );

        $this->subjectRepo->method('find')->with(1)->willReturn($subject);

        $subjects = $this->useCase->onlyRegisteredSubjects($dto);
        $this->assertSame([$subject], $subjects);
    }
}
