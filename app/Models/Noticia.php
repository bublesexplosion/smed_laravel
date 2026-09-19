<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Noticia extends Model
{
    protected $table = 'noticias';

    protected $fillable = [
        'origem_id', 'autor_id', 'noticia_pai_id', 'tipo', 'status', 'titulo', 'slug',
        'resumo', 'conteudo', 'data_criacao', 'data_publicacao', 'data_modificacao',
        'comentario_status', 'ping_status', 'ordem', 'mime_type', 'url_origem',
    ];

    protected function casts(): array
    {
        return [
            'data_criacao' => 'datetime',
            'data_publicacao' => 'datetime',
            'data_modificacao' => 'datetime',
        ];
    }

    public function scopePublicadas(Builder $query): Builder
    {
        return $query->where('status', 'publish')
            ->whereNotIn('tipo', ['revision', 'attachment']);
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    public function midias(): HasMany
    {
        return $this->hasMany(Midia::class, 'noticia_pai_id')->orderBy('id');
    }
}
