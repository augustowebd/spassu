<?php

namespace Archivus\Domain\Subject;

interface RepositoryInterface
{
    public function all(): array;
    public function exists(Subject $subject): bool;
    public function find(int $id): ?Subject;
    public function save(Subject $subject): Subject;
    public function remove(Subject $subject): void;
}
