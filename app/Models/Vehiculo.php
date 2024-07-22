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
        'precio_venta',
        'foto_url',
        'estado',
    ];

    public function compras()
    {
        return $this->belongsToMany(Compra::class, 'id_vehiculo');
    }
}
