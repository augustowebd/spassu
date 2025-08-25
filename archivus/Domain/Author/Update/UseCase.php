<?php

namespace Archivus\Domain\Author\Update;

use Archivus\Domain\Author\Author;
use Archivus\Domain\Author\RepositoryInterface;
use Archivus\Domain\Author\Shared\Exceptions\AuthorNotFoundException;
use Archivus\Domain\Author\Shared\Exceptions\AuthorSaveException;
use Archivus\Domain\Author\Shared\ValueObject\Name;
use Archivus\Shared\Text;
use Exception;

readonly class UseCase
{
    public function __construct(private RepositoryInterface $repository)
    { }

    public function execute(Request $dto): ?Author
    {
        $author = $this->repository->find($dto->id);

        AuthorNotFoundException::throwsIf(empty($author));

        $author->name = Name::from($dto->name);

        try {
            $this->repository->save($author);
        } catch (Exception) {
            AuthorSaveException::throwsIf(true, Text::ERR_UPDATE_FAILED);
        }

        return $author;
    }
}
