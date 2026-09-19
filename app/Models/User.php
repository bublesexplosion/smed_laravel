<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\MenuSection;
use App\Models\Group;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Adicione estas propriedades aqui dentro:
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relação com os Grupos (Tabela pivô user_groups)
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'user_groups');
    }

    /**
     * Busca os menus permitidos para os grupos do usuário
     */
  // app/Models/User.php
    public function getMenuData()
    {
        // Use apenas 'id' em vez de 'groups.id' para garantir que o array venha limpo
        $groupIds = $this->groups()->pluck('groups.id')->toArray();


        return MenuSection::with(['menuItems' => function ($query) use ($groupIds) {
            $query->whereHas('groups', function ($q) use ($groupIds) {
                $q->whereIn('groups.id', $groupIds);
            })->orderBy('order');
        }])
        ->orderBy('order')
        ->get()
        ->filter(fn($section) => $section->menuItems->isNotEmpty())
        ->values()
        ->all();
    }

}
