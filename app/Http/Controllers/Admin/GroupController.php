<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GroupController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Groups/Index', [
            'groups' => Group::with('menuItems')->get(),
            
            'menuItems' => MenuItem::with('menuSection')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        // Verifique se na tabela 'menu_sections' o campo é 'name' ou 'label'
                        // Se for 'name', use: $item->menuSection->name
                        'label' => ($item->menuSection ? $item->menuSection->name : 'Sem Seção') . ' / ' . $item->label,
                    ];
                })
                ->sortBy('label')
                ->values(),
        ]);
    }

    public function store(Request $request)
    {
        // Remova o dd($request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'menu_item_ids' => 'array'
        ]);

        // Cria o grupo APENAS com name e description
        $group = Group::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        if ($request->has('menu_item_ids')) {
            $group->menuItems()->sync($request->menu_item_ids);
        }

        return redirect()->back()->with('message', 'Grupo criado com sucesso!');
    }


   public function update(Request $request, Group $group)
    {
        // 1. Validação (se o 'name' for único, lembre-se de ignorar o ID atual)
        $validated = $request->validate([
            'name' => 'required|string|max:255', 
            'description' => 'required|string|max:255',
            'menu_item_ids' => 'array'
        ]);

        // 2. Update explícito apenas dos campos necessários
        $group->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        // 3. Sincronização da pivô
        $group->menuItems()->sync($request->input('menu_item_ids', []));

        return redirect()->back()->with('message', 'Grupo atualizado!');
    }


    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->back()->with('message', 'Grupo removido!');
    }
}
