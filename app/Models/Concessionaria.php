<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concessionaria extends Model
{
     protected $table = 'concessionarias';

    protected $fillable = [
        'descricao',
        'comimposto',
        'semimposto',
        'fiob',
        'dtcad',
        'user_id'
    ];
}
