@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Novo Assunto</h3>

        <form id="create-form" method="POST">
            @csrf

            <div class="row g-3">
                <!-- nome -->
                <div class="col-md-6">
                    <label for="description" class="form-label">Assunto <span class="text-danger">*</span></label>
                    <input type="text" name="description" id="description" class="form-control" maxlength="20" required>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('home') }}" class="btn btn-secondary">Cancelar</a>
                    <a href="{{ route('home') }}" class="btn btn-success"> Tela Principal</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@vite(['resources/js/subjects/create.js'])
