<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 250);
            $table->string('apellido', 250);
            $table->string('correo', 250)->unique();
            $table->string('numero_telefono', 20);
            $table->string('cedula', 20)->unique();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};
