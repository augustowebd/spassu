<?php

namespace App\Infrastructure\Persistence;

use App\Infrastructure\Mappers\SubjectMapper as Mapper;
use App\Models\Assunto as Model;
use Archivus\Domain\Subject\RepositoryInterface;
use Archivus\Domain\Subject\Subject as Entity;

class SubjectEloquentRepositoryImpl implements RepositoryInterface
{
    public function all(): array
    {
        return Model::with(['livros'])
            ->get()
            ->toArray();
    }

    public function find(int $id): ?Entity
    {
        /** @var Model $model */
        $model = Model::with(['livros'])
            ->where(['codAs' => $id])
            ->first();

        if (!$model) {
            return null;
        }

        return Mapper::toDomain($model);
    }

    /**
     * UPSERT strategy
     */
    public function save(Entity $subject): Entity
    {
        $model = $subject->id
            ? Model::find($subject->id)
            : new Model();

        $model->descricao = $subject->description;
        $model->save();

        $subject->id = $model->codAs;

        return $subject;
    }

    public function exists(Entity $subject): bool
    {
        return Model::where(['descricao' => $subject->description])->exists();
    }

    public function remove(Entity $subject): void
    {
        // preferi usar o delete para manter a cadeia de eventos
        // do laravel funcional, ou seja, posso escutar os eventos
        // deleting e deleted
        Model::where(['codAs' => $subject->id])->delete();
    }
}
