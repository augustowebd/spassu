<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\VwLivroAssunto;
use App\Models\VwLivroAutor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __invoke(Request $request): View
    {
        $type = $request->input('type');

        if ('subject' == $request->input('type')) {
            return $this->subject();
        }

        return $this->author();
    }

    private function author(): View
    {
        $autores = VwLivroAutor::all();
        return view('reports.author', compact('autores'));
    }

    private function subject(): View
    {
        $data = VwLivroAssunto::all();
        return view('reports.subject', compact('data'));
    }
}
