<?php
class Pedido extends Model {
    public $table = "pedidos";
    
    public $cliente_id;
    public $vendedor_id;
    public $transporte_id;
}