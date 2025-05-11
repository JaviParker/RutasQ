<?php

// app/Models/Problem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    use HasFactory;

    protected $table = 'incidencias';

    protected $fillable = [
        'usuarioid',
        'tipo',
        'titulo',
        'descripcion',
        'estado',
    ];

    public $timestamps = false;

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'usuarioid', 'usuarioid');
    }
}

