<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Cliente extends Model 
{
    use HasFactory, Notifiable;
    
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'numero_telefono',
        'cedula',
    ];
}
