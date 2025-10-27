<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('empresa_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('nivel_acesso', ['superadmin', 'admin', 'operador'])->default('operador');
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('empresa_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('admins');
    }
};