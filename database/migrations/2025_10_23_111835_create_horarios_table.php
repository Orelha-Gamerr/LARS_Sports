<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quadra_id')->constrained()->onDelete('cascade');
            $table->time('horario_inicio');
            $table->time('horario_fim');
            $table->boolean('disponivel')->default(true);
            $table->timestamps();
            
            $table->index('quadra_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('horarios');
    }
};