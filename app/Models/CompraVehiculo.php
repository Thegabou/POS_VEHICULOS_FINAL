<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraVehiculo extends Model
{
    use HasFactory;

    protected $table = 'compra_vehiculo';
    protected $fillable = [
        'compra_id',
        'vehiculo_id',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'id_compra');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'id_vehiculo');
    }
}
