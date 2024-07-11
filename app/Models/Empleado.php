<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'cedula',
        'cargo',
    ];

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id_empleado');
    }
}

