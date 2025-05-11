<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialCompra extends Model
{
    use HasFactory;

    protected $table = 'historial';
    protected $fillable = ['diaNombre', 'diaNumero', 'mes', 'año', 'total'];

    public $timestamps = false;
}
