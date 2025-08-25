@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <!-- Loader -->
        <div id="loader" class="text-center my-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Autores</h3>

            <nav>
                <ul class="pagination justify-content-center" id="pagination"></ul>
            </nav>

            <a href="{{ route('authors.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Novo
            </a>
        </div>

        <!-- Grid -->
        <div id="myContainer" class="d-none">
            <table class="table table-hover align-middle">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody id="myBody"></tbody>
            </table>
        </div>
    </div>

    <!-- Modal de edição -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editItemForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Autor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <input type="hidden" name="id" id="edit_id">

                             <div class="col-md-6">
                            <label for="edit_name" class="form-label">Nome</label>
                            <input type="text" id="edit_name" name="name" class="form-control" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@vite(['resources/js/authors/grid.js'])
