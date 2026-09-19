<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuPrincipal;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class MenuPrincipalController extends Controller
{
   public function index(Request $request)
    {
        // 1. Captura o termo de busca enviado pelo input
        $search = $request->input('search');

        // 2. Cria a query base com os relacionamentos e a ordenação
        $query = \App\Models\MenuPrincipal::with('pai')->orderBy('ordem');

        // 3. Aplica o filtro condicional se houver uma busca
        if ($search) {
            $query->where('label', 'like', "%{$search}%"); 
            // Substitua 'rotulo' pelo nome real da coluna de texto do seu banco (ex: nome, titulo)
        }

        // 4. Executa a consulta final
        $menus = $query->get();

        $opcoesMenu = \App\Models\MenuPrincipal::orderBy('label')->get();

        // 5. Retorna para a view passando as variáveis e o termo buscado
        return Inertia::render('Admin/MenuPrincipal/MenuPrincipal', [
            'menus' => $menus,
            'opcoesMenu' => $opcoesMenu,
            'filters' => ['search' => $search]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'     => 'required|string|max:255',
            'href'      => 'nullable|string',
            'icon'      => 'nullable|string',
            'ordem'     => 'nullable|integer',
            'descricao' => 'nullable|string|max:255',
            'parent_id' => 'nullable|integer|exists:menuPrincipal,id', // Tabela correta
        ]);

        // Define a ordem se vier nula
        $parent_id = $request->parent_id;
        $ordemDesejada = $request->ordem ?? (MenuPrincipal::where('parent_id', $parent_id)->max('ordem') + 1);

        DB::transaction(function () use ($validated, $ordemDesejada, $parent_id) {
            MenuPrincipal::where('parent_id', $parent_id)
                ->where('ordem', '>=', $ordemDesejada)
                ->increment('ordem');

            $validated['ordem'] = $ordemDesejada;
            MenuPrincipal::create($validated);
        });

        return redirect()->back()->with('message', 'Item criado!');
    }

    public function update(Request $request, $id)
    {
        $menu = MenuPrincipal::findOrFail($id);

        $validated = $request->validate([
            'label'     => 'required|string|max:255',
            'href'      => 'nullable|string',
            'icon'      => 'nullable|string',
            'ordem'     => 'required|integer',
            'descricao' => 'nullable|string|max:255',
            'parent_id' => 'nullable|integer|exists:menuPrincipal,id', // Tabela correta
        ]);

        $ordemAntiga = $menu->ordem;
        $novaOrdem = $request->ordem;
        $novoPai = $request->parent_id;

        DB::transaction(function () use ($menu, $validated, $ordemAntiga, $novaOrdem, $novoPai) {
            if ($menu->parent_id != $novoPai) {
                // Reordena pai antigo
                MenuPrincipal::where('parent_id', $menu->parent_id)
                    ->where('ordem', '>', $ordemAntiga)
                    ->decrement('ordem');

                // Abre espaço no pai novo
                MenuPrincipal::where('parent_id', $novoPai)
                    ->where('ordem', '>=', $novaOrdem)
                    ->increment('ordem');
            } 
            elseif ($novaOrdem !== $ordemAntiga) {
                if ($novaOrdem < $ordemAntiga) {
                    MenuPrincipal::where('parent_id', $novoPai)
                        ->whereBetween('ordem', [$novaOrdem, $ordemAntiga - 1])
                        ->increment('ordem');
                } else {
                    MenuPrincipal::where('parent_id', $novoPai)
                        ->whereBetween('ordem', [$ordemAntiga + 1, $novaOrdem])
                        ->decrement('ordem');
                }
            }

            $menu->update($validated);
        });

        return redirect()->back()->with('message', 'Item atualizado!');
    }

    public function destroy($id)
    {
        $menu = \App\Models\MenuPrincipal::findOrFail($id);
        $menu->delete();

        // Retorna redirecionamento padrão do Laravel/Inertia
        return redirect()->back();
    }



}//fim class
