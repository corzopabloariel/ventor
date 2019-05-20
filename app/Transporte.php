<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transporte extends Model
{
    protected $table = "transportesventor";
    protected $fillable = [
        'tracod',
        'descrp',
        'tradir',
        'telefn',
        'respon'
    ];
}
