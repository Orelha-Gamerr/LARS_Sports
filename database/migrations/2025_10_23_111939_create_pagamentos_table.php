<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserva_id')->constrained()->onDelete('cascade');
            $table->decimal('valor', 8, 2);
            $table->enum('metodo', ['pix', 'cartao_credito', 'cartao_debito', 'dinheiro']);
            $table->enum('status', ['pendente', 'pago', 'cancelado', 'estornado'])->default('pendente');
            $table->string('codigo_transacao')->nullable();
            $table->timestamp('data_pagamento')->nullable();
            $table->timestamps();
            
            $table->index('reserva_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagamentos');
    }
};