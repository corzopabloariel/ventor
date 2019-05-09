<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
        'nombre',
        'image',
        'color',
        'hsl',
        'padre_id',
        'orden',
        'tipo'
    ];
    
    public function padre()
    {
        return $this->belongsTo('App\Categoria');
    }
    public function hijos()
    {
        return $this->hasMany('App\Categoria','padre_id','id')->orderBy('orden');
    }
    
    public function getCategoriaEnteroAttribute() {
        $padre = self::recursivo($this->padre);
        return "{$padre}<br/><strong style='color:#009AD6'>{$this->nombre}</strong>";
    }
    public function recursivo($data) {
        if(empty($data->padre))
            return "<strong style='color: {$data["color"]}'>{$data["nombre"]}</strong>";
        else
            return self::recursivo($data->padre) . "<br/>{$data["nombre"]}";
    }
}
