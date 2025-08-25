<?php

namespace Archivus\Domain\Author\UpdateCatalog;

use Archivus\Domain\Author\RepositoryInterface as Repository;
use Archivus\Shared\UnitOfWorkInterface as UnitOfWork;

readonly class UseCase
{
    public function __construct(
        private UnitOfWork $unitOfWork,
        private Repository $repository,
    ) { ; }

    public function execute(Request $request): void
    {
        $this->unitOfWork->execute(function() use ($request) {
            $author = $this->repository->find($request->authorId);
            $author->syncBooks($request->books);
            $this->repository->save($author);
        });
    }
}
