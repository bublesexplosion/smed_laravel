<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class MenuPrincipal extends Model
{
    // Informamos ao Laravel o nome exato da tabela
    protected $table = 'menuPrincipal';

    protected $fillable = ['label', 'icon', 'href', 'ordem', 'parent_id', 'descricao'];

    // Relacionamento para buscar os filhos (Camada 2 e 3)
    public function subitems()
    {
        return $this->hasMany(MenuPrincipal::class, 'parent_id')->orderBy('ordem');
    }

    // Relacionamento inverso (caso precise saber quem é o pai)
    public function pai()
    {
        return $this->belongsTo(MenuPrincipal::class, 'parent_id');
    }
}
