<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\MenuSection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuItemController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/MenuItems/Index', [
            // Trazemos o nome da seção junto para a tabela
            'items' => MenuItem::with('menuSection:id,name')->orderBy('order')->get(),
            // Enviamos as seções para o Select do Modal
            'sections' => MenuSection::all(['id', 'name'])
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'link' => 'required|string',
            'menu_section_id' => 'required|exists:menu_sections,id',
            'order' => 'required|integer'
        ]);

        MenuItem::create($request->all());
        return redirect()->back()->with('message', 'Item de menu criado!');
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'link' => 'required|string',
            'menu_section_id' => 'required|exists:menu_sections,id',
            'order' => 'required|integer'
        ]);

        $menuItem->update($request->all());
        return redirect()->back()->with('message', 'Item atualizado!');
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return redirect()->back()->with('message', 'Item removido!');
    }
}
