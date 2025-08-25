<?php

namespace App\Http\Controllers\Api\Author;

use App\Models\Autor as Query;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorComboController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $authors = Query::query()->orderBy('nome')->get();

        return response()->json($authors);
    }
}
