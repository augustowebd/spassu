@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Novo Autor</h3>

        <form id="create-form" method="POST">
            @csrf

            <div class="row g-3">
                <!-- nome -->
                <div class="col-md-6">
                    <label for="name" class="form-label">Nome <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" maxlength="40" required>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('authors.index') }}" class="btn btn-secondary">Cancelar</a>
                    <a href="{{ route('home') }}" class="btn btn-success"> Tela Principal</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@vite(['resources/js/authors/create.js'])
