<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('origem_id')->nullable()->unique();
            $table->foreignId('autor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('noticia_pai_id')->nullable()->constrained('noticias')->nullOnDelete();
            $table->string('tipo', 40)->default('post');
            $table->string('status', 20)->default('publish')->index();
            $table->text('titulo');
            $table->string('slug', 200)->unique();
            $table->longText('resumo')->nullable();
            $table->longText('conteudo');
            $table->dateTime('data_criacao')->nullable();
            $table->dateTime('data_publicacao')->nullable()->index();
            $table->dateTime('data_modificacao')->nullable();
            $table->string('comentario_status', 20)->nullable();
            $table->string('ping_status', 20)->nullable();
            $table->integer('ordem')->default(0);
            $table->string('mime_type', 100)->nullable();
            $table->text('url_origem')->nullable();
            $table->timestamps();
            $table->index(['tipo', 'status']);
        });

        Schema::create('midias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('origem_id')->nullable()->unique();
            $table->foreignId('noticia_pai_id')->nullable()->constrained('noticias')->nullOnDelete();
            $table->text('titulo');
            $table->string('slug', 200)->nullable();
            $table->longText('descricao')->nullable();
            $table->text('legenda')->nullable();
            $table->text('url')->nullable();
            $table->text('caminho_relativo')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->dateTime('data_criacao')->nullable();
            $table->timestamps();
            $table->index('noticia_pai_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('midias');
        Schema::dropIfExists('noticias');
    }
};
