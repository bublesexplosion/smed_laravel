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
        Schema::create('menuPrincipal', function (Blueprint $table) {
                $table->id();
                $table->string('label');          // Ex: "Prefeitura"
                $table->string('icon')->nullable(); // Ex: "fas fa-home"
                $table->string('href')->nullable(); // Ex: "/secretarias" ou route('nome')
                $table->integer('ordem')->default(0);
                $table->string('descricao', 255)->nullable();

                // Auto-relacionamento para as 3 camadas
                $table->foreignId('parent_id')
                    ->nullable()
                    ->constrained('menuPrincipal') // Aponta para a própria tabela
                    ->onDelete('cascade');

                $table->timestamps();
            });
        }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menuPrincipal');
    }
};
