<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoVentor extends Model
{
    protected $table = "productosventor";

    protected $fillable = [
        'stmpdh_art',
        'use',
        'codigo_ima',
        'stmpdh_tex',
        'usr_stmpdh',
        'precio',
        'web_marcas',
        'parte',
        'parte_dbf_',
        'modelo_y_a',
        'usr_stmati',
        'grupo_web',
        'cantminvta',
        'fecha_ingr',
        'nro_refere'
    ];
}
