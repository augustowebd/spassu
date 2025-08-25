<?php

namespace App\Http\Controllers\Api\Author;

use App\Http\Controllers\Controller;
use App\Models\Autor as Query;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorListController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 10);
        $orderBy = $request->input('order_by', 'nome');

        $result = Query::query()
            ->orderBy($orderBy)
            ->paginate($perPage);

        return response()->json($result);
    }
}
