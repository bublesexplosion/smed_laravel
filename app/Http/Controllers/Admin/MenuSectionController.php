<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuSection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuSectionController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/MenuSections/Index', [
            'sections' => MenuSection::orderBy('order')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'icon'=>'required|string|max:255',
        ]);

        MenuSection::create($request->all());
        return redirect()->back()->with('message', 'Seção criada com sucesso!');
    }

    public function update(Request $request, MenuSection $menuSection)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'icon' => 'required|string|max:255',
        ]);

        $menuSection->update($request->all());
        return redirect()->back()->with('message', 'Seção atualizada!');
    }

    public function destroy(MenuSection $menuSection)
    {
        $menuSection->delete();
        return redirect()->back()->with('message', 'Seção removida!');
    }
}
