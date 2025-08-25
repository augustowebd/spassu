<?php

declare(strict_types=1);

use Archivus\Domain\Author\Shared\ValueObject\Name;
use Archivus\Domain\Subject\Shared\ValueObject\Description;
use Archivus\Domain\Subject\Subject;
use PHPUnit\Framework\TestCase;
use Archivus\Domain\Book\Update\UseCase;
use Archivus\Domain\Book\Update\Request;
use Archivus\Domain\Book\Book;
use Archivus\Domain\Author\Author;
use Archivus\Domain\Book\RepositoryInterface as BookRepo;
use Archivus\Domain\Author\RepositoryInterface as AuthorRepo;
use Archivus\Domain\Subject\RepositoryInterface as SubjectRepo;

final class UpdateBookUseCaseTest extends TestCase
{
    private BookRepo $bookRepo;
    private AuthorRepo $authorRepo;
    private SubjectRepo $subjectRepo;
    private UseCase $useCase;

    protected function setUp(): void
    {
        $this->bookRepo = $this->createMock(BookRepo::class);
        $this->authorRepo = $this->createMock(AuthorRepo::class);
        $this->subjectRepo = $this->createMock(SubjectRepo::class);

        $this->useCase = new UseCase(
            repository: $this->bookRepo,
            authorRepo: $this->authorRepo,
            subjectRepo: $this->subjectRepo
        );
    }

    public function testExecuteCreatesBookAndSaves(): void
    {
        $dto = new Request(
            id: 1,
            title: 'Livro Teste',
            publisher: 'Editora Alfa',
            edition: '1ª',
            year: 2023,
            price: 50.0,
            authorIds: [10],
            subjectIds: [20]
        );

        $author = new Author(id: 10, name: Name::from('Autor'));
        $subject = new Subject(id: 20, description: new Description('Matemática'));

        $this->authorRepo->method('find')->with(10)->willReturn($author);
        $this->subjectRepo->method('find')->with(20)->willReturn($subject);

        $this->bookRepo->expects($this->once())
            ->method('save')
            ->with($this->callback(fn(Book $b) =>
                $b->id === 1 &&
                $b->title === 'Livro Teste' &&
                $b->authors === [$author] &&
                $b->subjects === [$subject]
            ))
            ->willReturnCallback(fn(Book $b) => $b);

        $result = $this->useCase->execute($dto);

        $this->assertInstanceOf(Book::class, $result);
        $this->assertSame('Livro Teste', $result->title);
        $this->assertSame([$author], $result->authors);
        $this->assertSame([$subject], $result->subjects);
    }
}
