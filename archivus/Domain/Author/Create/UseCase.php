<?php

namespace Archivus\Domain\Author\Create;

use Archivus\Domain\Author\Author;
use Archivus\Domain\Author\RepositoryInterface as Repository;
use Archivus\Domain\Author\Shared\Exceptions\AuthorExistsException;
use Archivus\Domain\Author\Shared\Exceptions\AuthorSaveException;
use Archivus\Domain\Author\Shared\Factory\AuthorFactory as Factory;
use Archivus\Shared\Text;
use Throwable;

readonly class UseCase
{
    public function __construct(
        private Factory    $factory,
        private Repository $repository
    ) { ; }

    /**
     * @throws AuthorSaveException
     * @throws AuthorExistsException
     */
    public function execute(Request $dto): Author
    {
        $author = $this->factory->create(name: $dto->name);

        AuthorExistsException::throwsIf($this->repository->exists($author));

        try {
            $this->repository->save($author);
        } catch (Throwable) {
            AuthorSaveException::throwsIf(true, Text::ERR_SAVE_FAILED);
        }

        return $author;
    }
}
