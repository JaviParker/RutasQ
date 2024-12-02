<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedido';
    protected $primaryKey = 'pedidoid';
    protected $fillable = ['clienteid', 'pedido_fecha', 'pedido_total', 'pedido_por_confirmar'];

    public $timestamps = false;

    public function productos()
    {
        return $this->hasMany(PedidoProducto::class, 'pedidoid');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'clienteid');
    }

    public function tienda()
    {
        return $this->belongsTo(Tienda::class, 'clienteid', 'usuarioid');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'clienteid', 'usuarioid');
    }

}

