<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        "cliente_id",
        "vendedor_id",
        "transporte_id"
    ];
    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }
}
