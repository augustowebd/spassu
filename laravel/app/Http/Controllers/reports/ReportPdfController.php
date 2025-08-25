<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\VwLivroAutor;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Http\Response;

class ReportPdfController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $autores = VwLivroAutor::orderBy('autor_nome')->get();

        $pdf = PDF::loadView('reports.author-pdf', compact('autores'))->setPaper('a4', 'portrait');

        return $pdf->download('relatorio_autores.pdf');
    }
}
