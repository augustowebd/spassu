<?php

declare(strict_types=1);

use Archivus\Domain\Subject\RepositoryInterface;
use PHPUnit\Framework\TestCase;
use Archivus\Domain\Subject\Update\UseCase;
use Archivus\Domain\Subject\Update\Request;
use Archivus\Domain\Subject\Shared\ValueObject\Description;
use Archivus\Domain\Subject\Shared\Exceptions\SubjectSaveException;
use Archivus\Domain\Subject\Subject;

final class UpdateSubjectUseCaseTest extends TestCase
{
    private $repository;
    private UseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(RepositoryInterface::class);
        $this->useCase = new UseCase($this->repository);
    }

    public function testExecuteUpdatesDescriptionSuccessfully(): void
    {
        $subject = new Subject(1, Description::from('Antiga'));
        $dto = new Request(1, Description::from('Nova'));

        $this->repository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($subject);

        $this->repository->expects($this->once())
            ->method('save')
            ->with($this->callback(fn($s) => $s->description->value === 'Nova'))
            ->willReturn($subject);

        $result = $this->useCase->execute($dto);

        $this->assertSame($subject, $result);
        $this->assertSame('Nova', $result->description->value);
    }

    public function testExecuteThrowsSubjectSaveExceptionOnRepositoryError(): void
    {
        $this->expectException(SubjectSaveException::class);

        $subject = new Subject(1, Description::from('Antiga'));
        $dto = new Request(1, Description::from('Nova'));

        $this->repository->method('find')->willReturn($subject);
        $this->repository->method('save')->willThrowException(new Exception('DB error'));

        $this->useCase->execute($dto);
    }
}
