<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Relatório de Autores</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background: #eee; }
        h3 { margin-top: 30px; }
    </style>
</head>
<body>
<h2>Relatório de Autores e seus Livros</h2>

@foreach ($autores as $autor)
    <h3>{{ $autor->autor_nome }} ({{ $autor->total_livros }} livros)</h3>

    <table>
        <thead>
        <tr>
            <th>Título</th>
            <th>Editora</th>
            <th>Edição</th>
            <th>Ano</th>
            <th>Preço</th>
            <th>Assuntos</th>
        </tr>
        </thead>
        <tbody>
        @php
            $livros = json_decode($autor->livros, true);
        @endphp
        @foreach ($livros as $livro)
            <tr>
                <td>{{ $livro['titulo'] }}</td>
                <td>{{ $livro['editora'] }}</td>
                <td>{{ $livro['edicao'] }}</td>
                <td>{{ $livro['anoPublicacao'] }}</td>
                <td>R$ {{ number_format($livro['preco'], 2, ',', '.') }}</td>
                <td>
                    @if (!empty($livro['assuntos']))
                        {{ implode(', ', array_column($livro['assuntos'], 'descricao')) }}
                    @else
                        Sem assuntos
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endforeach
</body>
</html>
