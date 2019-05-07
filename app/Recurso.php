<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    protected $fillable = [
        'titulo',
        'zona',
        'descripcion',
        'orden',
        'in_zone'
    ];
}
