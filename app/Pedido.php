<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = "pedidos";
    protected $fillable = [
        "autofecha",
        "cliente_id",
        "vendedor_id",
        "usuario_id",
        "transporte_id",
        "is_adm",
        "estado",
        "observaciones"
    ];
    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }
    public function transporte()
    {
        return $this->belongsTo('App\Transporte');
    }
    public function hijos()
    {
        return $this->hasMany('App\PedidoProducto','pedido_id','id');
    }
}
