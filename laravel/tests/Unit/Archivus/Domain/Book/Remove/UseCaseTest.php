<?php

declare(strict_types=1);

use Archivus\Domain\Book\Book;
use PHPUnit\Framework\TestCase;
use Archivus\Domain\Book\Remove\UseCase;
use Archivus\Domain\Book\Remove\Request;
use Archivus\Domain\Book\RepositoryInterface as Repository;
use Archivus\Domain\Book\Shared\Exceptions\BookRemoveException;
use Archivus\Shared\Text;

final class UseCaseTest extends TestCase
{
    private const EXPECTED_ID = 1704;

    private Repository $repository;
    private UseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(Repository::class);
        $this->useCase = new UseCase($this->repository);
    }

    public function testExecuteReturnsNullWhenBookNotFound(): void
    {
        $dto = new Request(self::EXPECTED_ID);

        $this->repository
            ->method('find')
            ->with(self::EXPECTED_ID)
            ->willReturn(null);

        $result = $this->useCase->execute($dto);

        $this->assertNull($result);
    }

    public function testExecuteRemovesBookSuccessfully(): void
    {
        $dto = new Request(self::EXPECTED_ID);
        $book = $this->createMock(Book::class);

        $this->repository
            ->method('find')
            ->with(self::EXPECTED_ID)
            ->willReturn($book);

        $this->repository
            ->expects($this->once())
            ->method('remove')
            ->with($book);

        $result = $this->useCase->execute($dto);

        $this->assertNull($result); // retorno esperado é null mesmo após remover
    }

    public function testExecuteThrowsBookRemoveExceptionOnFailure(): void
    {
        $dto = new Request(self::EXPECTED_ID);
        $book = $this->createMock(Book::class);

        $this->repository
            ->method('find')
            ->willReturn($book);

        $this->repository
            ->method('remove')
            ->willThrowException(new RuntimeException('DB error'));

        $this->expectException(BookRemoveException::class);
        $this->expectExceptionMessage(Text::ERR_REMOVE_FAILED);

        $this->useCase->execute($dto);
    }
}
