<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    protected $fillable = ['name', 'description'];

    /**
     * Relacionamento com Usuários (Muitos para Muitos)
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_groups');
    }

    /**
     * Relacionamento com Itens de Menu (Muitos para Muitos)
     */
    public function menuItems()
    {
        return $this->belongsToMany(MenuItem::class, 'group_menu_items');
    }

}//fim class
