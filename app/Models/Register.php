<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;

    protected $table = 'registro';
    public $timestamps = false;

    protected $fillable = [
        'fecha_hora',
        'mensaje_recibido',
        'mensaje_enviado',
        'id_wa',
        'telefono_wa',
        'timestamp_wa'
    ];
}
