<?php

declare(strict_types=1);

use Archivus\Domain\Author\Author;
use Archivus\Domain\Author\RepositoryInterface;
use Archivus\Domain\Author\Shared\Exceptions\AuthorNotFoundException;
use Archivus\Domain\Author\Shared\Exceptions\AuthorSaveException;
use Archivus\Domain\Author\Shared\ValueObject\Name;
use Archivus\Domain\Author\Update\Request;
use Archivus\Domain\Author\Update\UseCase;
use Archivus\Shared\Text;
use PHPUnit\Framework\TestCase;

final class UpdateUseCaseTest extends TestCase
{
    private RepositoryInterface $repository;
    private UseCase $useCase;

    private const EXPECTED_ID = 1704;
    private const EXPECTED_NAME = 'Floquinho';

    protected function setUp(): void
    {
        $this->repository = $this->createMock(RepositoryInterface::class);
        $this->useCase = new UseCase($this->repository);
    }

    public function testExecuteUpdatesAuthorSuccessfully(): void
    {
        $author = new Author(id: self::EXPECTED_ID, name: Name::from('Old Name'), books: null);
        $dto = new Request(id: self::EXPECTED_ID, name: Name::from(self::EXPECTED_NAME));

        $this->repository
            ->method('find')
            ->with(self::EXPECTED_ID)
            ->willReturn($author);

        $this->repository
            ->expects($this->once())
            ->method('save')
            ->with($author);

        $result = $this->useCase->execute($dto);

        $this->assertSame($author, $result);
        $this->assertSame(self::EXPECTED_NAME, (string)$result->name);
    }

    public function testExecuteThrowsAuthorSaveExceptionWhenSaveFails(): void
    {
        $author = new Author(id: self::EXPECTED_ID, name: Name::from('Old Name'), books: null);
        $dto = new Request(id: self::EXPECTED_ID, name: Name::from(self::EXPECTED_NAME));

        $this->repository
            ->method('find')
            ->willReturn($author);

        $this->repository
            ->method('save')
            ->willThrowException(new Exception('DB error'));

        $this->expectException(AuthorSaveException::class);
        $this->expectExceptionMessage(Text::ERR_UPDATE_FAILED);

        $this->useCase->execute($dto);
    }

    public function testExecuteThrowsAuthorNotFoundExceptionWhenAuthorDoesNotExist(): void
    {
        $dto = new Request(id: self::EXPECTED_ID, name: Name::from(self::EXPECTED_NAME));

        $this->repository
            ->method('find')
            ->with(self::EXPECTED_ID)
            ->willReturn(null);

        $this->expectException(AuthorNotFoundException::class);

        $this->useCase->execute($dto);
    }
}
