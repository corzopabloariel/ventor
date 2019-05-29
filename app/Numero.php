<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Numero extends Model
{
    protected $fillable = [
        'orden',
        'provincia',
        'nombre',
        'persona',
        'interno',
        'email',
        'is_vendedor'
    ];
}
