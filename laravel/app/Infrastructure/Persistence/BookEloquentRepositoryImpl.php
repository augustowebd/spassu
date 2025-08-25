<?php

namespace App\Infrastructure\Persistence;

use App\Infrastructure\Mappers\BookMapper as Mapper;
use App\Models\Livro as Model;
use Archivus\Domain\Book\Book as Entity;
use Archivus\Domain\Book\RepositoryInterface;

class BookEloquentRepositoryImpl implements RepositoryInterface
{
    public function all(): array
    {
        return Model::with([
            'autores',
            'assuntos'
        ])->get()
            ->toArray();
    }

    public function find(int $id): ?Entity
    {
        /** @var Model $model */
        $model = Model::with(['autores', 'assuntos'])->where(['codl' => $id])->first();

        if (! $model) { return null; }

        return Mapper::toDomain($model);
    }

    /**
     * UPSERT strategy
     */
    public function save(Entity $entity): Entity
    {
        $model = $entity->id
            ? Model::find($entity->id)
            : new Model();

        $model->titulo = $entity->title;
        $model->editora = $entity->publisher;
        $model->edicao = $entity->edition;
        $model->anoPublicacao = $entity->year;
        $model->preco = $entity->price;
        $model->save();

        $model->autores()?->sync(
            array_map(fn($a) => $a->id, $entity->authors)
        );

        $model->assuntos()?->sync(
            array_map(fn($s) => $s->id, $entity->subjects)
        );

        $entity->id = $model->codl;

        return $entity;
    }

    public function remove(Entity $entity): void
    {
        // preferi usar o delete para manter a cadeia de eventos
        // do laravel funcional, ou seja, posso escutar os eventos
        // deleting e deleted
        Model::find($entity->id)->delete();
    }
}
