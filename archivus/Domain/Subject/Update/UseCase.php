<?php

namespace Archivus\Domain\Subject\Update;

use Archivus\Domain\Subject\RepositoryInterface;
use Archivus\Domain\Subject\Shared\Exceptions\SubjectSaveException;
use Archivus\Domain\Subject\Shared\ValueObject\Description;
use Archivus\Domain\Subject\Subject;
use Exception;

readonly class UseCase
{
    public function __construct(private RepositoryInterface $repository)
    { }

    public function execute(Request $dto): ?Subject
    {
        $subject = $this->repository->find($dto->id);
        $subject->description = Description::from($dto->description);

        try {
            $this->repository->save($subject);
        } catch (Exception $e) {
            SubjectSaveException::throwsIf(true, $e->getMessage());
        }

        return $subject;
    }
}
