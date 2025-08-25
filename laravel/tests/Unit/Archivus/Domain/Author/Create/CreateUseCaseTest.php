<?php

declare(strict_types=1);

use Archivus\Domain\Author\Author;
use Archivus\Domain\Author\Create\Request;
use Archivus\Domain\Author\Create\UseCase;
use Archivus\Domain\Author\RepositoryInterface as Repository;
use Archivus\Domain\Author\Shared\Exceptions\AuthorExistsException;
use Archivus\Domain\Author\Shared\Exceptions\AuthorSaveException;
use Archivus\Domain\Author\Shared\Factory\AuthorFactory as Factory;
use Archivus\Domain\Author\Shared\ValueObject\Name;
use Archivus\Shared\Text;
use PHPUnit\Framework\TestCase;

final class CreateUseCaseTest extends TestCase
{
    public const string EXPECTED_NAME = 'floquinho';

    private Factory $factory;
    private Repository $repository;
    private UseCase $useCase;

    protected function setUp(): void
    {
        $this->factory = $this->createMock(Factory::class);
        $this->repository = $this->createMock(Repository::class);

        $this->useCase = new UseCase(
            factory: $this->factory,
            repository: $this->repository
        );
    }

    public function testExecuteReturnsAuthorWhenSuccessful(): void
    {
        $dto = new Request(Name::from(self::EXPECTED_NAME));
        $author = $this->createMock(Author::class);

        $this->factory
            ->expects($this->once())
            ->method('create')
            ->with(self::EXPECTED_NAME)
            ->willReturn($author);

        $this->repository
            ->expects($this->once())
            ->method('exists')
            ->with($author)
            ->willReturn(false);

        $this->repository
            ->expects($this->once())
            ->method('save')
            ->with($author);

        $result = $this->useCase->execute($dto);

        $this->assertSame($author, $result);
    }

    public function testExecuteThrowsAuthorExistsExceptionWhenAlreadyExists(): void
    {
        $dto = new Request(Name::from(self::EXPECTED_NAME));
        $author = $this->createMock(Author::class);

        $this->factory
            ->method('create')
            ->willReturn($author);

        $this->repository
            ->method('exists')
            ->with($author)
            ->willReturn(true);

        $this->expectException(AuthorExistsException::class);

        $this->useCase->execute($dto);
    }

    public function testExecuteThrowsAuthorSaveExceptionWhenSaveFails(): void
    {
        $dto = new Request(Name::from(self::EXPECTED_NAME));
        $author = $this->createMock(Author::class);

        $this->factory
            ->method('create')
            ->willReturn($author);

        $this->repository
            ->method('exists')
            ->willReturn(false);

        $this->repository
            ->method('save')
            ->willThrowException(new RuntimeException('DB error'));

        $this->expectException(AuthorSaveException::class);
        $this->expectExceptionMessage(Text::ERR_SAVE_FAILED);

        $this->useCase->execute($dto);
    }
}
