<?php

use App\Http\Controllers\reports\ReportController;
use App\Http\Controllers\reports\ReportCsvController;
use App\Http\Controllers\reports\ReportPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('book.grid'); })->name('home');

Route::get('/authors', function () { return view('author.grid'); })->name('authors.index');
Route::get('/authors-create', function () { return view('author.create'); })->name('authors.create');

Route::get('/books', function () { return view('book.grid'); })->name('books.index');
Route::get('/books-create', function () { return view('book.create'); })->name('books.create');

Route::get('/subjects', function () { return view('subject.grid'); })->name('subjects.index');
Route::get('/subjects-create', function () { return view('subject.create'); })->name('subjects.create');

Route::get('/reports', ReportController::class)->name('reports.authors.index');
Route::get('/reports/authors/pdf', ReportPdfController::class)->name('reports.authors.pdf');
Route::get('/reports/authors/csv', ReportCsvController::class)->name('reports.authors.csv');
