<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoProducto extends Model
{
    protected $table = "pedidoproductos";
    protected $fillable = [
        "cnt",
        "producto_id",
        "pedido_id",
        "observ"
    ];
}
