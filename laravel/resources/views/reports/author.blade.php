@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Relatório de Autores e seus Livros</h3>

        <div class="mb-3">
            <a href="{{ route('reports.authors.pdf') }}" class="btn btn-danger me-2">
                Exportar PDF
            </a>
            <a href="{{ route('reports.authors.csv') }}" class="btn btn-success">
                Exportar CSV
            </a>
        </div>

        <div class="accordion" id="accordionAutores">
            @foreach ($autores as $index => $autor)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-{{ $index }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $index }}" aria-expanded="false"
                                aria-controls="collapse-{{ $index }}">
                            <strong>{{ $autor->autor_nome }}</strong>
                            <span class="badge bg-secondary ms-2">
                                {{ $autor->total_livros }} livros
                            </span>
                        </button>
                    </h2>
                    <div id="collapse-{{ $index }}" class="accordion-collapse collapse"
                         aria-labelledby="heading-{{ $index }}" data-bs-parent="#accordionAutores">
                        <div class="accordion-body">
                            @php
                                $livros = json_decode($autor->livros, true);
                            @endphp

                            @if ($livros && count($livros) > 0)
                                <table class="table table-sm table-bordered align-middle">
                                    <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Título</th>
                                        <th>Editora</th>
                                        <th>Edição</th>
                                        <th>Ano</th>
                                        <th>Preço</th>
                                        <th>Assuntos</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($livros as $livro)
                                        <tr>
                                            <td>{{ $livro['livro_id'] }}</td>
                                            <td>{{ $livro['titulo'] }}</td>
                                            <td>{{ $livro['editora'] }}</td>
                                            <td>{{ $livro['edicao'] }}</td>
                                            <td>{{ $livro['anoPublicacao'] }}</td>
                                            <td>R$ {{ number_format($livro['preco'], 2, ',', '.') }}</td>
                                            <td>
                                                @if (!empty($livro['assuntos']))
                                                    <ul class="mb-0 ps-3">
                                                        @foreach ($livro['assuntos'] as $assunto)
                                                            <li>{{ $assunto['descricao'] }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <em>Sem assuntos</em>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted">Nenhum livro encontrado.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
