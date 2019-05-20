<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = "clientesventor";
    protected $fillable = [
        'nrocta',
        'nombre',
        'respon',
        'usrvtmcl',
        'direcc',
        ''
    ];
}
