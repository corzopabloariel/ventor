<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Novedad extends Model
{
    protected $table = "novedades";
    protected $fillable = [
        'documento',
        'image',
        'nombre',
        'url',
        'orden'
    ];
}
