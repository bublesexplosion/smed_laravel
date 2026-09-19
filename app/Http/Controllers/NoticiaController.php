<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NoticiaController extends Controller
{
    public function index(Request $request): Response
    {
        $noticias = Noticia::publicadas()
            ->withCount('midias')
            ->when($request->filled('busca'), function ($query) use ($request) {
                $busca = $request->string('busca')->toString();
                $query->where(function ($query) use ($busca) {
                    $query->where('titulo', 'like', "%{$busca}%")
                        ->orWhere('resumo', 'like', "%{$busca}%");
                });
            })
            ->orderByDesc('data_publicacao')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        return Inertia::render('Noticias/Index', [
            'noticias' => $noticias,
            'filtros' => ['busca' => $request->string('busca')->toString()],
        ]);
    }

    public function show(Noticia $noticia): Response
    {
        abort_unless($noticia->status === 'publish' && !in_array($noticia->tipo, ['revision', 'attachment'], true), 404);

        return Inertia::render('Noticias/Show', [
            'noticia' => $noticia->load('midias'),
        ]);
    }
}
