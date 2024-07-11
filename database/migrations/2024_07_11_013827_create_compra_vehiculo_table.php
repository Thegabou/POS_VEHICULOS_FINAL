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
        Schema::create('compra_vehiculo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_vehiculo')->constrained('vehiculos')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('cantidad');
            $table->foreignId('id_compra')->constrained('compras')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });
    
        Schema::create('venta_vehiculo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_vehiculo')->constrained('vehiculos')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('cantidad');
            $table->foreignId('id_factura')->constrained('facturas')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('compra_vehiculo');
        Schema::dropIfExists('venta_vehiculo');
    }
    
};
