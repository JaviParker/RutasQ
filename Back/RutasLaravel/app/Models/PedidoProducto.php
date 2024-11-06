<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoProducto extends Model
{
    use HasFactory;

    protected $fillable = ['pedidoid', 'productoid', 'cantidad'];

    public $timestamps = false;

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedidoid');
    }

    public function producto()
    {
        return $this->belongsTo(Product::class, 'productoid');
    }
}

