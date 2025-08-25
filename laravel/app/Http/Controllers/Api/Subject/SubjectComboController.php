<?php

namespace App\Http\Controllers\Api\Subject;

use App\Http\Controllers\Controller;
use App\Models\Assunto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubjectComboController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $authors = Assunto::query()
            ->orderBy('descricao')
            ->get();

        return response()->json($authors);
    }
}
