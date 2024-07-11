<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('correo', 250)->unique();
            $table->string('contrasena');
            $table->foreignId('id_empleado')->constrained('empleados')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
    
};
