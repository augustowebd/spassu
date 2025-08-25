<?php

namespace Archivus\Domain\Book\Remove;

use Archivus\Domain\Book\RepositoryInterface as Repository;
use Archivus\Domain\Book\Shared\Exceptions\BookRemoveException;
use Archivus\Shared\Text;
use Throwable;

readonly class UseCase
{
    public function __construct(private Repository $repository)
    { ; }

    public function execute(Request $dto)
    {
        $result = $this->repository->find($dto->id);

        // se o objetivo é remover e, para o caso de informar o id dum
        // livro inexistente, o objetivo foi alcançado por W.O \0/
        if (empty($result)) { return null; }

        try {
            $this->repository->remove($result);
        } catch (Throwable) {
            BookRemoveException::throwsIf(true, Text::ERR_REMOVE_FAILED);
        }
    }
}
