<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraVehiculo extends Model
{
    use HasFactory;

    protected $table = 'compra_vehiculo';

    protected $fillable = [
        'id_vehiculo',
        'cantidad',
        'id_compra',
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'id_vehiculo');
    }

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'id_compra');
    }
}
