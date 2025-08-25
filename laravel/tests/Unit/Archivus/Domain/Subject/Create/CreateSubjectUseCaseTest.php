<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Archivus\Domain\Subject\Create\Request;
use Archivus\Domain\Subject\Create\UseCase;
use Archivus\Domain\Subject\RepositoryInterface;
use Archivus\Domain\Subject\Shared\Factory\SubjectFactory;
use Archivus\Domain\Subject\Shared\Exceptions\SubjectExistsException;
use Archivus\Domain\Subject\Shared\Exceptions\SubjectSaveException;
use Archivus\Domain\Subject\Subject;
use Archivus\Domain\Subject\Shared\ValueObject\Description;

final class CreateSubjectUseCaseTest extends TestCase
{
    private RepositoryInterface $repository;
    private SubjectFactory $factory;
    private UseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(RepositoryInterface::class);
        $this->factory = $this->createMock(SubjectFactory::class);
        $this->useCase = new UseCase(factory: $this->factory, repository: $this->repository);
    }

    public function testExecuteReturnsSubjectWhenSuccessful(): void
    {
        $description = Description::from('Matemática');
        $dto = new Request($description);

        $subject = $this->createMock(Subject::class);

        $this->factory
            ->expects($this->once())
            ->method('create')
            ->with(description: $description)
            ->willReturn($subject);

        $this->repository
            ->expects($this->once())
            ->method('exists')
            ->with($subject)
            ->willReturn(false);

        $this->repository
            ->expects($this->once())
            ->method('save')
            ->with($subject);

        $result = $this->useCase->execute($dto);

        $this->assertSame($subject, $result);
    }

    public function testExecuteThrowsSubjectExistsException(): void
    {
        $description = Description::from('Matemática');
        $dto = new Request($description);
        $subject = $this->createMock(Subject::class);

        $this->factory->method('create')->willReturn($subject);
        $this->repository->method('exists')->with($subject)->willReturn(true);

        $this->expectException(SubjectExistsException::class);

        $this->useCase->execute($dto);
    }

    public function testExecuteThrowsSubjectSaveException(): void
    {
        $description = Description::from('Matemática');
        $dto = new Request($description);
        $subject = $this->createMock(Subject::class);

        $this->factory->method('create')->willReturn($subject);
        $this->repository->method('exists')->willReturn(false);
        $this->repository->method('save')->willThrowException(new Exception('DB error'));

        $this->expectException(SubjectSaveException::class);
        $this->expectExceptionMessage('DB error');

        $this->useCase->execute($dto);
    }
}
