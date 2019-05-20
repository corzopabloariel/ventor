<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModeloVentor extends Model
{
    protected $table = "modeloventor";
    protected $fillable = [
        'modelo_y_a',
        'marca_id'
    ];
    
    public function marca()
    {
        return $this->belongsTo('App\MarcaVentor');
    }
}
