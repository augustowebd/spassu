<?php

namespace Archivus\Domain\Book\Update;

use Archivus\Domain\Book\Book;
use Archivus\Domain\Book\RepositoryInterface as Repository;
use Archivus\Domain\Author\RepositoryInterface as AuthorRepository;
use Archivus\Domain\Subject\RepositoryInterface as SubjectRepository;

readonly class UseCase
{
    public function __construct(
        private Repository        $repository,
        private AuthorRepository  $authorRepo,
        private SubjectRepository $subjectRepo,
    ) { ; }

    public function execute(Request $dto): Book
    {
        $book = new Book(
            id: $dto->id,
            title: $dto->title,
            publisher: $dto->publisher,
            edition: $dto->edition,
            year: $dto->year,
            price: $dto->price,
            authors: $this->onlyRegisteredAuthors($dto),
            subjects: $this->onlyRegisteredSubjects($dto),
        );

        return $this->repository->save($book);
    }

    /**
     * @param Request $dto
     * @return array
     */
    public function onlyRegisteredAuthors(Request $dto): array
    {
        return array_map(fn($id) => $this->authorRepo->find($id), $dto->authorIds);
    }

    /**
     * @param Request $dto
     * @return array
     */
    public function onlyRegisteredSubjects(Request $dto): array
    {
        return array_map(fn($id) => $this->subjectRepo->find($id), $dto->subjectIds);
    }
}
