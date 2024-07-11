<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaVehiculo extends Model
{
    use HasFactory;

    protected $table = 'venta_vehiculo';

    protected $fillable = [
        'id_vehiculo',
        'cantidad',
        'id_factura',
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'id_vehiculo');
    }

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura');
    }
}
