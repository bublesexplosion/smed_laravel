<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuSection extends Model
{
    protected $fillable = ['name', 'order','icon'];

    /**
     * Uma seção tem muitos itens de menu
     */
    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'menu_section_id')->orderBy('order');
    }
}
