<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('tipos_cadastros', function (Blueprint $table) {
        $table->id();
        $table->string('nome_unico')->unique(); // Vai salvar 'bitola', 'bucha', 'disjuntor'
        $table->string('label');               // Vai salvar 'Bitolas', 'Buchas', 'Disjuntores'
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_cadastros');
    }
};
