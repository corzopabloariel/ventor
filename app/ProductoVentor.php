<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoVentor extends Model
{
    protected $table = "productosventor";

    protected $fillable = [
        'fecha_ingr',
        'stmpdh_art',
        'use',
        'codigo_ima',
        'stmpdh_tex',
        'usr_stmpdh',
        'precio',
        'familia_id',
        'parte_id',
        'modelo_id',
        'grupo_web',
        'cantminvta',
        'nro_refere',

        //'web_marcas',
        //'parte',
        //'parte_dbf_',
        //'modelo_y_a',
        //'usr_stmati',
    ];

    public function modelo()
    {
        return $this->belongsTo('App\ModeloVentor');
    }
    public function familia()
    {
        return $this->belongsTo('App\FamiliaVentor');
    }
    public function parte()
    {
        return $this->belongsTo('App\PartesVentor');
    }
    public function familia_id() {
        return $this->familia["usr_stmati"];
    }
    public function parte_id() {
        return "<strong>{$this->parte["cod"]}</strong><br/>{$this->parte["descrp"]}";
    }
    public function modelo_id() {
        if(!empty($this->modelo["marca"]["web_marcas"]))
            return "<strong>{$this->modelo["marca"]["web_marcas"]}</strong><br/>{$this->modelo["modelo_y_a"]}";
        else
            return "{$this->modelo["modelo_y_a"]}";
    }
    public function getPrecio() {
        return number_format($this->precio,2,",",".");
    }
}
