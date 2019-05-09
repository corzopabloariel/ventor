<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descarga extends Model
{
    protected $fillable = [
        'orden',
        'documento',
        'nombre',
        'image'
    ];
}
