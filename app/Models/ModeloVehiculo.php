<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloVehiculo extends Model
{
    use HasFactory;

    protected $fillable = ['id_marca', 'modelo_vehiculo'];

    public function marca()
    {
        return $this->belongsTo(MarcaVehiculo::class, 'id_marca');
    }

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class, 'id_modelo');
    }
}