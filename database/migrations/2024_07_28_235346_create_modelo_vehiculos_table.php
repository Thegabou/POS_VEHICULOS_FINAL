<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModeloVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelo_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_marca')->constrained('marca_vehiculos')->onDelete('restrict')->onUpdate('restrict');
            $table->string('modelo_vehiculo');
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
        Schema::dropIfExists('modelo_vehiculos');
    }
}