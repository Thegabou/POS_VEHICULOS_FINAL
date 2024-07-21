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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('marca', 250);
            $table->string('modelo', 250);
            $table->year('año_modelo');
            $table->string('tipo_vehiculo', 250);
            $table->decimal('precio_compra', 10, 2);
            $table->decimal('kilometraje', 10, 2);
            $table->string('foto_url', 250);
            $table->decimal('precio_venta', 10, 2);
            $table->enum('estado', ['Disponible', 'Vendido', 'Reservado'])->default('Disponible');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('vehiculos');
    }
    
};
