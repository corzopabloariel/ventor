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
        'codpos',//localidad
        'descrp',//localidad
        'descr_001',//localidad
        'telefn',
        'nrofax',
        'direml',
        'nrodoc',
        'descr_002',
        'usrvt_003',//TRANSPORTE
        'vnddor',//vendedor
        'descr_003',//vendedor
        'nrotel',//vendedor
        'camail',//vendedor
        'usrvt_004',
        'usrvt_005',
        'usrvt_006',
        'usrvt_007',
        'usrvt_008',
        'usrvt_009',
        'usrvt_010',
        'usrvt_011',
        'usrvt_012',
        'usrvt_013',
        'usrvt_014',
        'usrvt_015',
        'usrvt_016',
        'usrvt_017',
        'usrvt_018',
        'usrvt_019',
        'usrvt_020',
        'usrvt_021'
    ];
}
