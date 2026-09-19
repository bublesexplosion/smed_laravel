<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadastroAuxiliar extends Model
{
    use HasFactory;

    // Vincula o model à tabela nova de itens auxiliares
    protected $table = 'cadastros_auxiliares';

    protected $fillable = [
        'tipo_cadastro_id', 
        'descricao',
        'valor',
        'aux_id',
        
        ];

    /**
     * Relacionamento: Cada registro pertence a um único tipo pai.
     */
    public function tipoCadastro()
    {
        return $this->belongsTo(TipoCadastro::class, 'tipo_cadastro_id');
    }
}
