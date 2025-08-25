<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Archivus\Domain\Subject\Remove\UseCase;
use Archivus\Domain\Subject\Remove\Request;
use Archivus\Domain\Subject\RepositoryInterface;
use Archivus\Domain\Subject\Subject;
use Archivus\Shared\Collections\Books;
use Archivus\Domain\Subject\Shared\Exceptions\CannotDeleteAuthorWithBooksException;
use Archivus\Domain\Subject\Shared\Exceptions\SubjectRemoveException;

final class RemoveSubjectUseCaseTest extends TestCase
{
    private RepositoryInterface $repository;
    private UseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(RepositoryInterface::class);
        $this->useCase = new UseCase($this->repository);
    }

    public function testReturnsNullWhenSubjectNotFound(): void
    {
        $dto = new Request(id: 1);

        $this->repository
            ->method('find')
            ->with(1)
            ->willReturn(null);

        $result = $this->useCase->execute($dto);
        $this->assertNull($result);
    }

    public function testThrowsCannotDeleteAuthorWithBooksException(): void
    {
        $dto = new Request(id: 1);

        $subject = $this->createMock(Subject::class);
        $subject->books = $this->createMock(Books::class);
        $subject->books
            ->method('isEmpty')
            ->willReturn(false);

        $this->repository
            ->method('find')
            ->willReturn($subject);

        $this->expectException(CannotDeleteAuthorWithBooksException::class);

        $this->useCase->execute($dto);
    }

    public function testRemovesSubjectSuccessfully(): void
    {
        $dto = new Request(id: 1);

        $subject = $this->createMock(Subject::class);
        $subject->books = $this->createMock(Books::class);
        $subject->books
            ->method('isEmpty')
            ->willReturn(true);

        $this->repository
            ->method('find')
            ->willReturn($subject);

        $this->repository
            ->expects($this->once())
            ->method('remove')
            ->with($subject);

        $this->useCase->execute($dto);
    }

    public function testThrowsSubjectRemoveExceptionWhenRepositoryFails(): void
    {
        $dto = new Request(id: 1);

        $subject = $this->createMock(Subject::class);
        $subject->books = $this->createMock(Books::class);
        $subject->books
            ->method('isEmpty')
            ->willReturn(true);

        $this->repository
            ->method('find')
            ->willReturn($subject);

        $this->repository
            ->method('remove')
            ->will($this->throwException(new \Exception("DB error")));

        $this->expectException(SubjectRemoveException::class);

        $this->useCase->execute($dto);
    }
}
