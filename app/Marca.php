<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = [
        'nombre',
        'image',
        'padre_id'
    ];
    protected $appends = ['nombre_entero'];

    public function modelos()
    {
        return $this->hasMany('App\Marca','padre_id','id')->orderBy('nombre');
    }
    public function padre()
    {
        return $this->belongsTo('App\Marca');
    }

    public function getNombreEnteroAttribute() {
        return "{$this->padre["nombre"]}<br/>{$this->nombre}";
    }
}
