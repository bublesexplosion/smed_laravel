<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoCadastro;
use App\Models\CadastroAuxiliar;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuxiliarController extends Controller
{
    /**
     * 1. TELA PRINCIPAL: Lista todos os TIPOS de cadastros 
     */
   public function indexTipos()
    {
        return Inertia::render('Admin/Tipos/Index', [ // <-- Pasta atualizada
            'tipos' => TipoCadastro::orderBy('label')->get()
        ]);
    }
    
    public function storeTipo(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255|unique:tipos_cadastros,label',
        ]);

        TipoCadastro::create([
            'label' => $request->label,
            'nome_unico' => \Str::slug($request->label) // Transforma "Disjuntores Elétricos" em "disjuntores-eletricos"
        ]);

        return redirect()->back()->with('message', 'Novo tipo de cadastro adicionado!');
    }

    public function updateTipo(Request $request, $id)
    {
        $tipo = TipoCadastro::findOrFail($id);

        $request->validate([
            'label' => "required|string|max:255|unique:tipos_cadastros,label,{$id}",
        ]);

        $tipo->update([
            'label' => $request->label,
            'nome_unico' => \Str::slug($request->label) // Atualiza o slug se o nome mudar
        ]);

        return redirect()->back()->with('message', 'Tabela atualizada com sucesso!');
    }

    public function destroyTipo($id)
    {
        $tipo = TipoCadastro::findOrFail($id);
        $tipo->delete();

        return redirect()->back()->with('message', 'Tabela removida com sucesso!');
    }

    /**
     * Abre o CRUD diretamente filtrado pelo tipo vindo da URL (ex: /admin/cadastros/bitola)
     */
    public function gerenciarRegistros($slug_tipo)
    {
        // Busca o tipo pelo nome único (slug) cadastrado
        $tipo = TipoCadastro::where('nome_unico', $slug_tipo)->firstOrFail();

        return Inertia::render('Admin/Cadastros/Index', [
            'tipo' => $tipo,
            'registros' => $tipo->registros()->orderBy('id')->get()
        ]);
    }
   
    public function storeRegistro(Request $request, $slug_tipo)
    {
        $tipo = TipoCadastro::where('nome_unico', $slug_tipo)->firstOrFail();

        $request->validate([
            'descricao' => "required|string|max:255|unique:cadastros_auxiliares,descricao,NULL,id,tipo_cadastro_id,{$tipo->id}",
            'valor'     => "nullable|numeric|min:0",
            'aux_id'   => "nullable|integer",

         ]);

        $tipo->registros()->create([
            'descricao' => $request->descricao,
            'valor'     => $request->valor,
            'aux_id'     => $request->aux_id,
            
        ]);

        return redirect()->back()->with('message', 'Registro adicionado com sucesso!');
    }
    
    public function updateRegistro(Request $request, $slug_tipo, $id)
    {
        $tipo = TipoCadastro::where('nome_unico', $slug_tipo)->firstOrFail();
        $registro = $tipo->registros()->findOrFail($id);

        $request->validate([
            'descricao' => "required|string|max:255|unique:cadastros_auxiliares,descricao,{$id},id,tipo_cadastro_id,{$tipo->id}",
            'valor'     => "nullable|numeric|min:0",
            'aux_id'   => "nullable|integer",
        ]);

        $registro->update([
            'descricao' => $request->descricao,
            'valor'     => $request->valor,
            'aux_id'     => $request->aux_id,
        ]);

        return redirect()->back()->with('message', 'Registro atualizado com sucesso!');
    }
    
    public function destroyRegistro($slug_tipo, $id)
    {
        $tipo = TipoCadastro::where('nome_unico', $slug_tipo)->firstOrFail();
        $registro = $tipo->registros()->findOrFail($id);
        $registro->delete();

        return redirect()->back()->with('message', 'Registro removido com sucesso!');
    }

}
