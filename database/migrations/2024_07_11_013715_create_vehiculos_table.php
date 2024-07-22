<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('marca');
            $table->string('modelo');
            $table->integer('año_modelo');
            $table->string('tipo');
            $table->decimal('precio_compra', 10, 2);
            $table->integer('kilometraje');
            $table->decimal('precio_venta', 10, 2);
            $table->string('foto_url')->nullable();
            $table->enum('estado', ['Disponible', 'Reservado', 'Vendido'])->default('Disponible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculos');
    }
}
