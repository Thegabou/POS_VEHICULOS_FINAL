<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarcaVehiculo extends Model
{
    use HasFactory;

    protected $fillable = ['marca_vehiculo'];

    public function modelos()
    {
        return $this->hasMany(ModeloVehiculo::class, 'id_marca');
    }

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class, 'id_marca');
    }
}