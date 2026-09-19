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
    Schema::create('cadastros_auxiliares', function (Blueprint $table) {
        $table->id();
        // Cria a chave estrangeira apontando para a tabela de tipos
        $table->foreignId('tipo_cadastro_id')->constrained('tipos_cadastros')->onDelete('cascade');
        $table->string('descricao');
        $table->unsignedBigInteger('aux_id')->nullable()->index(); 
        $table->decimal('valor', 10, 2)->nullable();

        $table->timestamps();
        
        // Evita que o usuário cadastre duas descrições idênticas dentro do mesmo tipo
        $table->unique(['tipo_cadastro_id', 'descricao']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cadastros_auxiliares');
    }
};
