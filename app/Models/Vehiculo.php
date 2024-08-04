<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_marca',
        'id_modelo',
        'año_modelo',
        'tipo_vehiculo',
        'precio_compra',
        'kilometraje',
        'precio_venta',
        'foto_url',
        'numero_chasis',
        'placa',
        'descripcion',
        'numero_motor',
        'estado',
    ];

    public function marca()
    {
        return $this->belongsTo(MarcaVehiculo::class, 'id_marca');
    }

    public function modelo()
    {
        return $this->belongsTo(ModeloVehiculo::class, 'id_modelo');
    }

    public function compras()
    {
        return $this->belongsToMany(Compra::class, 'compra_vehiculo', 'id_vehiculo', 'id_compra');
    }
}
