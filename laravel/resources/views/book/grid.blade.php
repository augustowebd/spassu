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
            <h3>Livros</h3>

            <!-- Paginação -->
            <nav>
                <ul class="pagination justify-content-center" id="pagination"></ul>
            </nav>

            <a href="{{ route('books.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Novo</a>
        </div>

        <!-- Grid de livros -->
        <div id="booksContainer" class="d-none">
            <table class="table table-hover align-middle">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Preço</th>
                    <th>Autores</th>
                    <th>Assuntos</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody id="booksBody"></tbody>
            </table>
        </div>
    </div>

    <!-- Modal de confirmação -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Confirmação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja remover este livro?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <span id="deleteBtnText">Remover</span>
                        <span id="deleteBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                              aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de edição -->
    <div class="modal fade" id="editBookModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editBookForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Livro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <input type="hidden" name="id" id="edit_id">

                        <div class="col-md-6">
                            <label for="edit_authors" class="form-label">Autores</label>
                            <select id="edit_authors" name="authors[]" class="form-select" multiple required>
                                <!-- opções serão carregadas via JS -->
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_subjects" class="form-label">Assuntos</label>
                            <select id="edit_subjects" name="subjects[]" class="form-select" multiple required>
                                <!-- opções serão carregadas via JS -->
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_title" class="form-label">Título</label>
                            <input type="text" id="edit_title" name="title" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_publisher" class="form-label">Editora</label>
                            <input type="text" id="edit_publisher" name="publisher" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label for="edit_edition" class="form-label">Edição</label>
                            <input type="number" id="edit_edition" name="edition" class="form-control" min="1" required>
                        </div>

                        <div class="col-md-3">
                            <label for="edit_year" class="form-label">Ano</label>
                            <input type="number" id="edit_year" name="year" class="form-control" min="1900" max="{{ date('Y') + 1 }}" required>
                        </div>

                        <div class="col-md-3">
                            <label for="edit_price" class="form-label">Preço</label>
                            <input type="text" id="edit_price" name="price" class="form-control" required>
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
@vite(['resources/js/books/grid.js'])
