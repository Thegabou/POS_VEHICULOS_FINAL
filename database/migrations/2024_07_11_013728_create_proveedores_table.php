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
    Schema::create('proveedores', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 250);
        $table->string('ruc', 20)->unique();
        $table->string('telefono', 10);
        $table->string('correo', 250);
        $table->string('direccion', 250);
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('proveedores');
}

};
