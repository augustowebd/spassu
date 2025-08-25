<?php

namespace Archivus\Domain\Subject\Remove;

use Archivus\Domain\Subject\RepositoryInterface;
use Archivus\Domain\Subject\Shared\Exceptions\CannotDeleteAuthorWithBooksException;
use Archivus\Domain\Subject\Shared\Exceptions\SubjectRemoveException;
use Throwable;

readonly class UseCase
{
    public function __construct(private RepositoryInterface $repository)
    { ; }

    public function execute(Request $dto)
    {
        $result = $this->repository->find($dto->id);

        if (empty($result)) { return null; }

        CannotDeleteAuthorWithBooksException::throwsNotIf($result->books->isEmpty());

        try {
            $this->repository->remove($result);
        } catch (Throwable) {
            SubjectRemoveException::throwsIf(true, "Erro ao remover o assunto");
        }
    }
}
