<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraVehiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'compra_id',
        'vehiculo_id',
        'cantidad',
        'precio',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
