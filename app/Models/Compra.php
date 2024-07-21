<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_factura',
        'fecha_compra',
        'proveedor_id',
        'vehiculo_id',
        'monto_final',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function vehiculos()
    {
        return $this->hasMany(CompraVehiculo::class);
    }
}
