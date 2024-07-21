<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->constrained()->onDelete('cascade');
            $table->foreignId('vehiculo_id')->constrained()->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2);
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
        Schema::dropIfExists('compra_vehiculos');
    }
}
