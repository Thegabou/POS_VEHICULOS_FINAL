<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $primaryKey = 'ruc';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ruc',
        'nombre',
        'correo',
        'telefono',
        'direccion',
    ];

    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_proveedor');
    }
}
