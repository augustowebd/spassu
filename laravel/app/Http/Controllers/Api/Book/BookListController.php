<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use App\Models\Livro as Query;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookListController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 10);
        $orderBy = $request->input('order_by', 'titulo');

        $authorId  = $request->query('a');
        $subjectId = $request->query('s');

        $books = Query::with(['autores', 'assuntos'])
            ->when($authorId, function ($query, $authorId) {
                $query->whereHas('autores', function ($q) use ($authorId) {
                    $q->where('codAu', $authorId);
                });
            })
            ->when($subjectId, function ($query, $subjectId) {
                $query->whereHas('assuntos', function ($q) use ($subjectId) {
                    $q->where('codAs', $subjectId);
                });
            })
            ->orderBy($orderBy)
            ->paginate($perPage);

        return response()->json($books);
    }
}
