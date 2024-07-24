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
        Schema::create('venta_vehiculo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_vehiculo')->constrained('vehiculos');
            $table->foreignId('id_factura')->constrained('facturas');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('venta_vehiculo');
    }

};
