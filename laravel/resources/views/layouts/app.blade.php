<!doctype html>
<html lang="pt-br" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Biblioteca')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div class="id">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Archivus</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">Manter</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/authors">Autor</a></li>
                            <li><a class="dropdown-item" href="/subjects">Assunto</a></li>
                            <li><a class="dropdown-item" href="/books">Livro</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">Relatórios</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('reports.authors.index') }}">Autor</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Theme Switcher -->
                <div class="dropdown me-3">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="themeSwitcher"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-circle-half"></i> Tema
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="themeSwitcher">
                        <li>
                            <button class="dropdown-item" data-bs-theme-value="light">
                                <i class="bi bi-sun"></i> Claro
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item" data-bs-theme-value="dark">
                                <i class="bi bi-moon-stars"></i> Escuro
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item" data-bs-theme-value="auto">
                                <i class="bi bi-circle-half"></i> Automático
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="d-flex justify-content-end p-3">
                    <button id="decrease-font" class="btn btn-outline-secondary btn-sm">A-</button>
                    <button id="increase-font" class="btn btn-outline-secondary btn-sm ms-2">A+</button>
                </div>
            </div>
        </div>
    </nav>

    <div class="my-4">
        @yield('content')
    </div>

    <!-- Tooltips -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto" id="toastTitle">Aviso</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Fechar"></button>
            </div>
            <div class="toast-body" id="toastBody"></div>
        </div>
    </div>

    <!-- modal confirmation -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Confirmação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja remover este item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <span id="deleteBtnText">Remover</span>
                        <span id="deleteBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@vite([
    'resources/js/font-size.js',
    'resources/js/showToast.js',
    'resources/js/switch-theme.js'
])
<!-- Bootstrap icons (para os ícones do tema) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@stack('scripts')
</body>
</html>
