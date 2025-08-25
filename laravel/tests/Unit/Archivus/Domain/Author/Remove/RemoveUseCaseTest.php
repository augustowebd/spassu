<?php

declare(strict_types=1);

use Archivus\Domain\Author\Author;
use Archivus\Domain\Author\Remove\Request;
use Archivus\Domain\Author\Remove\UseCase;
use Archivus\Domain\Author\RepositoryInterface as Repository;
use Archivus\Domain\Author\Shared\Exceptions\AuthorRemoveException;
use Archivus\Domain\Author\Shared\Exceptions\CannotDeleteAuthorWithBooksException;
use Archivus\Shared\Collections\Books;
use Archivus\Shared\Text;
use PHPUnit\Framework\TestCase;

final class RemoveUseCaseTest extends TestCase
{
    public const int EXPECTED_ID = 1704;

    private Repository $repository;
    private UseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(Repository::class);
        $this->useCase = new UseCase($this->repository);
    }

    public function testExecuteReturnsNullWhenAuthorNotFound(): void
    {
        $dto = new Request(self::EXPECTED_ID);

        $this->repository
            ->method('find')
            ->with(self::EXPECTED_ID)
            ->willReturn(null);

        $result = $this->useCase->execute($dto);

        $this->assertNull($result);
    }

    public function testExecuteRemovesAuthorWhenNoBooks(): void
    {
        $dto = new Request(self::EXPECTED_ID);

        // Mock de coleção de livros
        $books = $this->createMock(Books::class);
        $books->method('isEmpty')->willReturn(true);

        // Mock de Author com propriedade $books
        $author = $this->createMock(Author::class);
        $author->books = $books;

        $this->repository
            ->method('find')
            ->with(self::EXPECTED_ID)
            ->willReturn($author);

        $this->repository
            ->expects($this->once())
            ->method('remove')
            ->with($author);

        $this->useCase->execute($dto);

        $this->assertTrue(true);
    }

    public function testExecuteThrowsExceptionWhenAuthorHasBooks(): void
    {
        $dto = new Request(self::EXPECTED_ID);

        $books = $this->createMock(Books::class);
        $books->method('isEmpty')->willReturn(false);

        $author = $this->createMock(Author::class);
        $author->books = $books;

        $this->repository
            ->method('find')
            ->willReturn($author);

        $this->expectException(CannotDeleteAuthorWithBooksException::class);

        $this->useCase->execute($dto);
    }

    public function testExecuteThrowsAuthorRemoveExceptionWhenRemoveFails(): void
    {
        $dto = new Request(self::EXPECTED_ID);

        $books = $this->createMock(Books::class);
        $books->method('isEmpty')->willReturn(true);

        $author = $this->createMock(Author::class);
        $author->books = $books;

        $this->repository
            ->method('find')
            ->willReturn($author);

        $this->repository
            ->method('remove')
            ->willThrowException(new RuntimeException('DB error'));

        $this->expectException(AuthorRemoveException::class);
        $this->expectExceptionMessage(Text::ERR_REMOVE_FAILED);

        $this->useCase->execute($dto);
    }
}
