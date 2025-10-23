<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quadras', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->enum('tipo', ['society', 'futsal', 'volei', 'basquete', 'tenis']);
            $table->text('descricao')->nullable();
            $table->decimal('preco_hora', 8, 2);
            $table->integer('capacidade')->default(10);
            $table->boolean('disponivel')->default(true);
            $table->string('imagem')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quadras');
    }
};