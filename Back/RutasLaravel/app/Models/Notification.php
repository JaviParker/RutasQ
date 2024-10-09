<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $fillable = ['nombre', 'mensaje', 'tipo_notificacion', 'productos_seleccionados', 'descripcion', 'precio'];

    public $timestamps = true;
}
