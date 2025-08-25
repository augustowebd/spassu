<?php

namespace Archivus\Domain\Author;

interface RepositoryInterface
{
    public function all(): array;
    public function exists(Author $entity): bool;
    public function find(int $id): ?Author;
    public function save(Author $entity): Author;
    public function remove(Author $entity): void;
}
