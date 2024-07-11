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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 250);
            $table->string('apellido', 250);
            $table->string('correo', 250)->unique();
            $table->string('cedula', 20)->unique();
            $table->string('cargo', 100);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
    
};
