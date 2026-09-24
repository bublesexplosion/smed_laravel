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
        $busca = $request->string('busca')->toString();
        $ordenacao = $request->string('ordenacao', 'recentes')->toString();

        $noticias = Noticia::publicadas()
            ->withCount('midias')
            ->when($busca !== '', function ($query) use ($busca) {
                $query->where(function ($query) use ($busca) {
                    $query->where('titulo', 'like', "%{$busca}%")
                        ->orWhere('resumo', 'like', "%{$busca}%");
                });
            })
            ->when($request->filled('data_inicio'), function ($query) use ($request) {
                $query->whereDate('data_publicacao', '>=', $request->date('data_inicio'));
            })
            ->when($request->filled('data_fim'), function ($query) use ($request) {
                $query->whereDate('data_publicacao', '<=', $request->date('data_fim'));
            })
            ->when($ordenacao === 'antigos', function ($query) {
                $query->orderBy('data_publicacao')->orderBy('id');
            })
            ->when($ordenacao === 'relevancia' && $busca !== '', function ($query) use ($busca) {
                $query->orderByRaw('titulo like ? desc', ["%{$busca}%"])
                    ->orderByDesc('data_publicacao');
            })
            ->when(!in_array($ordenacao, ['antigos', 'relevancia'], true) || ($ordenacao === 'relevancia' && $busca === ''), function ($query) {
                $query->orderByDesc('data_publicacao')->orderByDesc('id');
            })
            ->paginate(9)
            ->withQueryString();

        return Inertia::render('Noticias/Index', [
            'noticias' => $noticias,
            'filtros' => [
                'busca' => $busca,
                'data_inicio' => $request->string('data_inicio')->toString(),
                'data_fim' => $request->string('data_fim')->toString(),
                'ordenacao' => $ordenacao,
            ],
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
