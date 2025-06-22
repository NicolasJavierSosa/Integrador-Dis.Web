<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoDetalle extends Model
{
    protected $fillable = ['pedido_id', 'producto_id', 'cantidad', 'precio'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
    
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
