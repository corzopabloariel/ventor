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

    public function modelos()
    {
        return $this->hasMany('App\Marca','padre_id','id')->orderBy('nombre');
    }
}
