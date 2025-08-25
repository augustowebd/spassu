<?php

namespace Archivus\Domain\Author\Remove;

use Archivus\Domain\Author\RepositoryInterface as Repository;
use Archivus\Domain\Author\Shared\Exceptions\AuthorRemoveException;
use Archivus\Domain\Author\Shared\Exceptions\CannotDeleteAuthorWithBooksException;
use Archivus\Shared\Text;
use Throwable;

readonly class UseCase
{
    public function __construct(private Repository $repository)
    { ; }

    public function execute(Request $dto)
    {
        $result = $this->repository->find($dto->id);

        if (empty($result)) { return null; }

        CannotDeleteAuthorWithBooksException::throwsNotIf($result->books->isEmpty());

        try {
            $this->repository->remove($result);
        } catch (Throwable) {
            AuthorRemoveException::throwsIf(true, Text::ERR_REMOVE_FAILED);
        }
    }
}
