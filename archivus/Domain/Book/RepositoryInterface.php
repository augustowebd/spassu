<?php

namespace Archivus\Domain\Book;

interface RepositoryInterface
{
    public function all(): array;
    public function find(int $id): ?Book;
    public function save(Book $entity): Book;
    public function remove(Book $entity): void;
}
