@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Novo Livro</h3>

        <form id="book-form" method="POST">
            @csrf

            <div class="row g-3">

                <!-- Autor -->
                <div class="col-md-6">
                    <label for="author_id" class="form-label">Autor <span class="text-danger">*</span>
                    </label>
                    <select name="author_id[]" id="author_id" class="form-select" multiple required>
                    </select>
                </div>

                <!-- Assunto -->
                <div class="col-md-6">
                    <label for="subject_id" class="form-label">
                        Assunto <span class="text-danger">*</span>
                    </label>
                    <select name="subject_id[]" id="subject_id" class="form-select" multiple required>
                    </select>
                </div>

                <!-- Título -->
                <div class="col-md-6">
                    <label for="title" class="form-label">
                        Título <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="title" id="title" class="form-control"
                           maxlength="40" required>
                </div>

                <!-- Editora -->
                <div class="col-md-6">
                    <label for="publisher" class="form-label">
                        Editora <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="publisher" id="publisher" class="form-control"
                           maxlength="40" required>
                </div>

                <!-- Edição -->
                <div class="col-md-3">
                    <label for="edition" class="form-label">
                        Edição <span class="text-danger">*</span>
                    </label>
                    <input type="number" name="edition" id="edition" class="form-control"
                           min="1" required>
                </div>

                <!-- Ano -->
                <div class="col-md-3">
                    <label for="year" class="form-label">
                        Ano <span class="text-danger">*</span>
                    </label>
                    <input type="number" name="year" id="year" class="form-control"
                           min="1900" max="{{ date('Y') + 1 }}" step="1" required>
                </div>

                <!-- Preço -->
                <div class="col-md-3">
                    <label for="price" class="form-label">
                        Preço <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="price" id="price" class="form-control" required>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancelar</a>
                <a href="{{ route('home') }}" class="btn btn-success"> Tela Principal</a>
            </div>
        </form>
    </div>
@endsection

@vite(['resources/js/books/create.js'])
