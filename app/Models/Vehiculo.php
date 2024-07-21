<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'marca', 
        'modelo', 
        'año_modelo', 
        'tipo_vehiculo', 
        'precio_compra', 
        'kilometraje',
        'estado', 
        'foto_url', 
        'precio_venta'
    ];

    public function compraVehiculos()
    {
        return $this->hasMany(CompraVehiculo::class);
    }

    public function inventario()
    {
        return $this->hasOne(Inventario::class, 'id_vehiculo');
    }
}
