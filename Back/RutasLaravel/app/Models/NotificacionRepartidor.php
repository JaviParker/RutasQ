<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacionRepartidor extends Model
{
    use HasFactory;

    protected $table = 'notificacion_repartidor';

    protected $fillable = [
        'mensaje',
        'fecha',
        'hora',
        'remitente_id',
    ];

    public $timestamps = false;

    public function remitente()
    {
        return $this->belongsTo(User::class, 'remitente_id', 'usuarioid');
    }

}
