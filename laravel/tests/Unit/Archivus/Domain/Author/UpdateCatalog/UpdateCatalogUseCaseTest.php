<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Archivus\Domain\Author\UpdateCatalog\UseCase;
use Archivus\Domain\Author\UpdateCatalog\Request;
use Archivus\Domain\Author\RepositoryInterface as Repository;
use Archivus\Shared\UnitOfWorkInterface as UnitOfWork;
use Archivus\Domain\Author\Author;
use Archivus\Shared\Collections\Books;
use Archivus\Domain\Book\Book;

final class UpdateCatalogUseCaseTest extends TestCase
{
    private Repository $repository;
    private UnitOfWork $unitOfWork;
    private UseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(Repository::class);
        $this->unitOfWork = $this->createMock(UnitOfWork::class);
        $this->useCase = new UseCase($this->unitOfWork, $this->repository);
    }

    public function testExecuteSyncsBooksAndSavesAuthor(): void
    {
        $book1 = new Book(1, 'Book One', 'Publisher A', '1st', 2024, 29.9);
        $book2 = new Book(2, 'Book Two', 'Publisher B', '2nd', 2025, 39.9);
        $books = new Books($book1, $book2);

        $author = $this->createMock(Author::class);
        $author->expects($this->once())
            ->method('syncBooks')
            ->with($books);

        $this->repository->expects($this->once())
            ->method('find')
            ->with(123)
            ->willReturn($author);

        $this->repository->expects($this->once())
            ->method('save')
            ->with($author);

        $this->unitOfWork->expects($this->once())
            ->method('execute')
            ->willReturnCallback(function ($callback) {
                $callback();
            });

        $request = new Request(authorId: 123, books: $books);

        $this->useCase->execute($request);
    }
}
