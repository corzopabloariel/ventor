<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarcaVentor extends Model
{
    protected $table = "marcasventor";
    protected $fillable = [
        'web_marcas'
    ];
}
