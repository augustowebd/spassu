<?php

namespace App\Http\Controllers\Api\Author;

use App\Models\Autor as Query;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorDetailController extends Controller
{
    public function __invoke(Request $request, int $authorId): JsonResponse
    {
        $query = Query::where(['codAu' => $authorId])->first();

        return response()->json(
            data: $query,
            status: empty($query)
                ? Response::HTTP_NOT_FOUND
                : Response::HTTP_OK
        );
    }
}
