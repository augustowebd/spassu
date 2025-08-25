<?php

namespace App\Infrastructure\Persistence;

use App\Infrastructure\Mappers\AuthorMapper as Mapper;
use App\Infrastructure\Mappers\BookMapper;
use App\Models\Autor as Model;
use App\Models\Livro;
use Archivus\Domain\Author\Author as Entity;
use Archivus\Domain\Author\RepositoryInterface;

readonly class AuthorEloquentRepositoryImpl implements RepositoryInterface
{
    public function all(): array
    {
        return Model::with(['livros'])
            ->get()
            ->all();
    }

    public function find(int $id): ?Entity
    {
        /** @var Model $model */
        $model = Model::with(['livros'])
            ->where(['codAu' => $id])->first();

        if (!$model) {
            return null;
        }

        return Mapper::toDomain($model);
    }

    /**
     * UPSERT strategy
     */
    public function save(Entity $entity): Entity
    {
        $model = $entity->id
            ? Model::where(['codAu' => $entity->id])->first()
            : new Model();

        $model->nome = $entity->name->value;
        $model->save();
        $entity->id = $model->codAu;

        $this->sync($model, $entity);

        return $entity;
    }

    public function remove(Entity $entity): void
    {
        // preferi usar o delete para manter a cadeia de eventos
        // do laravel funcional, ou seja, posso escutar os eventos
        // deleting e deleted
        Model::where(['codAu' => $entity->id])->delete();
    }

    public function exists(Entity $entity): bool
    {
        return Model::where(['nome' => $entity->name])->exists();
    }

    private function sync(Model $author, Entity $entity): void
    {
        $booksId = [];
        $books = $entity->books ?: [];

        foreach ($books as $book) {
            $data = BookMapper::toRepository($book);
            $bookId = $data['codl'];
            unset($data['codl']);

            $bookModel = $bookId
                ? Livro::firstOrCreate(['codl' => $bookId], $data)
                : Livro::create($data);

            $booksId[] = $bookModel->codl;
        }

        $author->livros()->sync($booksId);
    }
}
