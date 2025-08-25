<?php

namespace Archivus\Domain\Subject\Create;

use Archivus\Domain\Subject\RepositoryInterface;
use Archivus\Domain\Subject\Shared\Exceptions\SubjectExistsException;
use Archivus\Domain\Subject\Shared\Exceptions\SubjectSaveException;
use Archivus\Domain\Subject\Shared\Factory\SubjectFactory;
use Archivus\Domain\Subject\Subject;
use Exception;

readonly class UseCase
{
    public function __construct(
        private SubjectFactory      $factory,
        private RepositoryInterface $repository
    ) { ; }

    /**
     * @throws SubjectSaveException
     * @throws SubjectExistsException
     */
    public function execute(Request $dto): Subject
    {
        $entity = $this->factory->create(description: $dto->description);
        SubjectExistsException::throwsIf($this->repository->exists($entity));

        try {
            $this->repository->save($entity);
        } catch (Exception $e) {
            SubjectSaveException::throwsIf(true, $e->getMessage());
        }

        return $entity;
    }
}
