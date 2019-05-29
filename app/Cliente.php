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
        'usrvt_001',
        'usrvt_002',
        'direcc',
        'localidad_id',//localidad
        'telefn',
        'nrofax',
        'direml',
        'nrodoc',
        'vendedor_id',
        'transporte_id',//TRANSPORTE
        'descr_002'
    ];
}
