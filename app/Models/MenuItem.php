<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Section;

class MenuItem extends Model
{
    protected $fillable = ['menu_section_id', 'label', 'link', 'icon', 'order'];

    /**
     * O item pertence a uma seção
     */
    public function menuSection(): BelongsTo
    {
        return $this->belongsTo(MenuSection::class, 'menu_section_id');
    }

    /**
     * Grupos que têm acesso a este item
     */
    // app/Models/MenuItem.php
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_menu_items');
    }


        /**
     * Um item de menu pode conter múltiplos subitens (Filhos)
     */
    public function subitems()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    /**
     * O item de menu pertence a um item pai
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }


}//fim class
