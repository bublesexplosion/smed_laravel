<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Midia extends Model
{
    protected $table = 'midias';

    protected $fillable = [
        'origem_id', 'noticia_pai_id', 'titulo', 'slug', 'descricao', 'legenda',
        'url', 'caminho_relativo', 'mime_type', 'data_criacao',
    ];

    protected function casts(): array
    {
        return ['data_criacao' => 'datetime'];
    }

    public function noticia(): BelongsTo
    {
        return $this->belongsTo(Noticia::class, 'noticia_pai_id');
    }
}
