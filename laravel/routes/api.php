<?php

use App\Http\Controllers\Api\Author\AuthorComboController;
use App\Http\Controllers\Api\Author\AuthorListController;
use App\Http\Controllers\Api\Author\AuthorCreateController;
use App\Http\Controllers\Api\Author\AuthorDetailController;
use App\Http\Controllers\Api\Author\AuthorUpdateController;
use App\Http\Controllers\Api\Author\AuthorRemoveController;

use App\Http\Controllers\Api\Book\BookListController;
use App\Http\Controllers\Api\Book\BookRemoveController;
use App\Http\Controllers\Api\Book\BookCreateController;
use App\Http\Controllers\Api\Book\BookUpdateController;
use App\Http\Controllers\Api\Book\BookDetailController;

use App\Http\Controllers\Api\Subject\SubjectCreateController;
use App\Http\Controllers\Api\Subject\SubjectListController;
use App\Http\Controllers\Api\Subject\SubjectComboController;
use App\Http\Controllers\Api\Subject\SubjectDetailController;

use App\Http\Controllers\Api\Subject\SubjectRemoveController;
use App\Http\Controllers\Api\Subject\SubjectUpdateController;
use Illuminate\Support\Facades\Route;

Route::get(uri: '/authors', action: AuthorListController::class)->name('authors.list');
Route::post(uri: '/authors', action: AuthorCreateController::class)->name('authors.create');
Route::get(uri: '/authors/combo', action: AuthorComboController::class)->name('authors.combo');
Route::get(uri: '/authors/{id}', action: AuthorDetailController::class)->name('authors.detail');
Route::put(uri: '/authors/{id}', action: AuthorUpdateController::class)->name('authors.edit');
Route::delete(uri: '/authors/{id}', action: AuthorRemoveController::class)->name('authors.remove');

Route::get(uri: '/books', action: BookListController::class)->name('books.list');
Route::post(uri: '/books', action: BookCreateController::class)->name('books.create');
Route::get(uri: '/subjects/combo', action: SubjectComboController::class)->name('subjects.combo');
Route::get(uri: '/books/{id}', action: BookDetailController::class)->name('books.detail');
Route::put(uri: '/books/{id}', action: BookUpdateController::class)->name('books.edit');
Route::delete(uri: '/books/{id}', action: BookRemoveController::class)->name('books.remove');

Route::get(uri: '/subjects', action: SubjectListController::class)->name('subjects.list');
Route::post(uri: '/subjects', action: SubjectCreateController::class)->name('subjects.create');
Route::get(uri: '/subjects/{id}', action: SubjectDetailController::class)->name('subjects.detail');
Route::put(uri: '/subjects/{id}', action: SubjectUpdateController::class)->name('subjects.edit');
Route::delete(uri: '/subjects/{id}', action: SubjectRemoveController::class)->name('subjects.remove');
