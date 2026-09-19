<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCadastro extends Model
{
    use HasFactory;

    // Vincula o model à tabela nova de tipos
    protected $table = 'tipos_cadastros';

    protected $fillable = ['nome_unico', 'label'];

    /**
     * Relacionamento: Um Tipo possui muitos registros filhos.
     * Ex: O tipo 'Bitolas' possui os itens '10mm', '16mm', etc.
     */
    public function registros()
    {
        return $this->hasMany(CadastroAuxiliar::class, 'tipo_cadastro_id');
    }
}
