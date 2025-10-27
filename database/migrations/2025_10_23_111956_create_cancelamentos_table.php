<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cancelamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserva_id')->constrained()->onDelete('cascade');
            $table->text('motivo');
            $table->enum('tipo', ['cliente', 'admin', 'sistema']);
            $table->timestamp('data_cancelamento');
            $table->decimal('valor_estornado', 8, 2)->nullable();
            $table->timestamps();
            
            $table->index('reserva_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cancelamentos');
    }
};