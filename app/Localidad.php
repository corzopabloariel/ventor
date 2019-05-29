<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $table = "localidades";
    protected $fillable = [
        'codpos',
        'descrp',
        'descr_001'
    ];
}
