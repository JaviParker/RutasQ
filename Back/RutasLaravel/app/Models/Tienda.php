<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    use HasFactory;

    protected $table = 'tienda'; // Nombre de la tabla en la base de datos

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'direccion',
        'usuarioid',
        'longitud',
        'latitud',
        'telefono',
    ];

    // Relación con el modelo User (un usuario tiene muchas tiendas)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuarioid');
    }

}
