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
            $table->foreignId('id_marca')->constrained('marca_vehiculos')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('id_modelo')->constrained('modelo_vehiculos')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('año_modelo');
            $table->string('tipo_vehiculo');
            $table->decimal('precio_compra', 10, 2);
            $table->decimal('kilometraje', 10, 2);
            $table->decimal('precio_venta', 10, 2);
            $table->string('foto_url')->nullable();
            $table->string('numero_chasis');
            $table->string('numero_motor');
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
