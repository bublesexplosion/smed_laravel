<?php

namespace App\Http\Controllers\Admin; // Namespace atualizado para a pasta Admin

use App\Http\Controllers\Controller; // Importação necessária do controlador base
use App\Models\Concessionaria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConcessionariaController extends Controller {
   
    public function index() {
        return Inertia::render('Admin/Concessionarias/Index', [
            'concessionarias' => Concessionaria::all()
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'descricao' => 'required|string|max:255',
            'comimposto' => 'required|numeric',
            'semimposto' => 'required|numeric',
            'fiob' => 'required|numeric',
            'dtcad' => 'required|date',
        ]);

        $validated['user_id'] = auth()->id() ?? 1;

        Concessionaria::create($validated);

        return redirect()->route('admin.concessionarias.index')
            ->with('message', 'Concessionária cadastrada com sucesso!');
    }

    public function update(Request $request, Concessionaria $concessionaria) {
        $validated = $request->validate([
            'descricao' => 'required|string|max:255',
            'comimposto' => 'required|numeric',
            'semimposto' => 'required|numeric',
            'fiob' => 'required|numeric',
            'dtcad' => 'required|date',
        ]);

        $concessionaria->update($validated);

        return redirect()->route('admin.concessionarias.index')
            ->with('message', 'Concessionária atualizada com sucesso!');
    }

    public function destroy(Concessionaria $concessionaria) {
        $concessionaria->delete();
        return redirect()->route('admin.concessionarias.index')
            ->with('message', 'Concessionária removida com sucesso!');
    }
}
