<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Familiaparte extends Model
{
    protected $table = "familiaparte";
    protected $fillable = [
        'categoria_id',
        'familia_id'
    ];

    
    public function categoria()
    {
        return $this->belongsTo('App\Categoria','categoria_id','id');
    }
}
