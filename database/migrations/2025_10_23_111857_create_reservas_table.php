<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');
            $table->foreignId('quadra_id')->constrained()->onDelete('cascade');
            $table->foreignId('horario_id')->constrained()->onDelete('cascade');
            $table->date('data_reserva');
            $table->enum('status', ['pendente', 'confirmado', 'cancelado', 'finalizado'])->default('pendente');
            $table->decimal('valor_total', 8, 2);
            $table->text('observacoes')->nullable();
            $table->timestamps();
            
            $table->index('cliente_id');
            $table->index('quadra_id');
            $table->index('horario_id');
            $table->index('data_reserva');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservas');
    }
};