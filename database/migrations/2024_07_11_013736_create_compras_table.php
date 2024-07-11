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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_compra')->nullable();
            $table->foreignId('id_proveedor')->constrained('proveedores')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('id_vehiculo')->constrained('vehiculos')->onDelete('restrict')->onUpdate('restrict');
            $table->decimal('monto_final', 10, 2);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('compras');
    }
    
};
