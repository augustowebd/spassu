<?php

namespace App\Http\Controllers\Api\Subject;

use App\Http\Controllers\Controller;
use App\Models\Assunto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubjectListController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 10);
        $orderBy = $request->input('order_by', 'descricao');

        $result = Assunto::query()
            ->orderBy($orderBy)
            ->paginate($perPage);

        return response()->json($result);
    }
}
