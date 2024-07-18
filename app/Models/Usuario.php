<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable implements MustVerifyEmail
{
    use HasFactory , Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'correo',
        'contrasena',
        'id_empleado',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];


    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}
