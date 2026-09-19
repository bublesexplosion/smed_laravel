<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use App\Traits\HasBreadcrumbs; 

class UserController extends Controller
{
    use HasBreadcrumbs;

    public function index()
    {
        // 1. Executa o Trait primeiro
        $this->setBreadcrumbs([
            ['label' => 'Administração', 'url' => null],
            ['label' => 'Usuários', 'url' => route('admin.users.index')],
        ]);

        // 2. Renderiza o componente passando apenas as props necessárias
        return Inertia::render('Admin/Users/Index', [
            'users' => User::with('groups:id,name')->get(),
            'groups' => Group::all(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'group_ids' => 'required|array' // Valida que veio um array dos checkboxes
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Aqui a mágica acontece: o Laravel preenche a tabela pivô user_groups
        $user->groups()->sync($request->group_ids);

        return redirect()->back()->with('message', 'Usuário criado com sucesso!');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'group_ids' => 'required|array'
        ]);

        $user->update($request->only('name', 'email'));

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Atualiza os vínculos: remove o que foi desmarcado e adiciona o novo
        $user->groups()->sync($request->group_ids);

        return redirect()->back()->with('message', 'Usuário atualizado!');
    }

    public function destroy(User $user)
    {
        // O Laravel cuidará de remover os vínculos se você usou onDelete('cascade') na migration
        $user->delete();
        return redirect()->back()->with('message', 'Usuário removido!');
    }
}
