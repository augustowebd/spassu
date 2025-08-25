<?php

namespace Archivus\Infrastructure\LaravelBind;

use App\Infrastructure\Persistence\AuthorEloquentRepositoryImpl;
use App\Infrastructure\Persistence\BookEloquentRepositoryImpl;
use App\Infrastructure\Persistence\SubjectEloquentRepositoryImpl;
use App\Infrastructure\Persistence\UnitOfWorkImpl;
use Archivus\Domain\Author\RepositoryInterface as AuthorRepositoryInterface;
use Archivus\Domain\Book\RepositoryInterface as BookRepositoryInterface;
use Archivus\Domain\Subject\RepositoryInterface as SubjectRepositoryInterface;
use Archivus\Shared\UnitOfWorkInterface;
use Illuminate\Support\ServiceProvider;

class ArchivusAppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        UnitOfWorkInterface::class => UnitOfWorkImpl::class,
        AuthorRepositoryInterface::class => AuthorEloquentRepositoryImpl::class,
        BookRepositoryInterface::class => BookEloquentRepositoryImpl::class,
        SubjectRepositoryInterface::class => SubjectEloquentRepositoryImpl::class,
    ];

    public function register(): void
    {
    }

    public function boot(): void
    {
    }
}
