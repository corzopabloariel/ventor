<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table = "vendedoresventor";
    protected $fillable = [
        'vnddor',
        'descrp',
        'natmer',
        'nrotel',
        'mail'
    ];
    public function pedidos()
    {
        return $this->hasMany('App\Pedido');
    }
}
