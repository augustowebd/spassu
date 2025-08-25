<?php

namespace App\Http\Controllers\Api\Subject;

use App\Http\Controllers\Controller;
use App\Models\Assunto as Query;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubjectDetailController extends Controller
{
    public function __invoke(Request $request, int $id): JsonResponse
    {
        $query = Query::where(['codAs' => $id])->first();

        return response()->json(
            data: $query,
            status: empty($query)
                ? Response::HTTP_NOT_FOUND
                : Response::HTTP_OK
        );
    }
}
