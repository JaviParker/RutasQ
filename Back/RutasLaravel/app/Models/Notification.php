<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $fillable = [
        'nombre', 
        'mensaje', 
        'fecha', 
        'remitente_id', 
        'destinatario_id', 
        'tipo_notificacion', 
        'productos_seleccionados', 
        'precio', 
        'tipo_oferta_aviso', 
        'descripcion', 
        'imagen'
    ];

    public $timestamps = false;
}
