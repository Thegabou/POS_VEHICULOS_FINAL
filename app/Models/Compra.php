<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_factura',
        'id_proveedor',
        'fecha_compra',
        'monto_final',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function vehiculos()
    {
        return $this->belongsToMany(Vehiculo::class, 'id_compra');
    }
}
