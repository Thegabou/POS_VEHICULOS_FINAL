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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignId('id_empleado')->constrained('empleados');
            $table->foreignId('id_cliente')->constrained('clientes');
            $table->string('tipo_pago');
            $table->text('datos_pago')->nullable();
            $table->decimal('sub_total', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturas');
    }
    
};
