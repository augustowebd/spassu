<?php

namespace App\Http\Controllers\Api\Book;

use App\Models\Livro;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class BookDetailController extends Controller
{
    public function __invoke(Request $request, int $bookId): JsonResponse
    {
        $book = Livro::with(['autores', 'assuntos'])
            ->where('codl', $bookId)
            ->first();

        return response()->json(
            data: $book,
            status: empty($book)
                ? Response::HTTP_NOT_FOUND
                : Response::HTTP_OK
        );
    }
}
