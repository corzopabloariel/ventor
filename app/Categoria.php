<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
        'nombre',
        'image',
        'color',
        'hsl',
        'padre_id',
        'orden',
        'tipo',
        'familia_id',
        'categoria_id'
    ];
    
    public function padre()
    {
        return $this->belongsTo('App\Categoria');
    }
    public function hijos()
    {
        return $this->hasMany('App\Categoria','padre_id','id')->orderBy('orden');
    }
    public function productos()
    {
        return $this->hasMany('App\Producto')->orderBy('orden');
    }
    public function familia()
    {
        return $this->belongsTo('App\FamiliaVentor');
    }
    public function categoria()
    {
        return $this->belongsTo('App\PartesVentor');
    }

    public function hijosTodos() {
        $hijos = $this->hijos;

        foreach($hijos AS $h)
            $h["hijos"] = self::hijosRecursivos($h);
        return $hijos;
    }
    public function hijosRecursivos($data) {
        if(empty($data->hijos))
            return [];
        else {
            $hijos = $data->hijos;
            foreach($hijos AS $h)
                $h["hijos"] = self::hijosRecursivos($h);
            return $hijos;
        }
    }
    public function padresRecursivo($data, &$padres, $tipo) {
        if(empty($data->padre))
            $padres[] = $tipo ? $data["id"] : ["nombre" => $data["nombre"], "id" => $data["id"]];
        else {
            $padres[] = $tipo ? $data["id"] : ["nombre" => $data["nombre"], "id" => $data["id"]];
            self::padresRecursivo($data->padre,$padres, $tipo);
        }
    }

    public function padres($tipo = 1) {
        $padres = [];
        self::padresRecursivo($this,$padres, $tipo);
        return $padres;
    }
    public function getCategoriaEnteroAttribute() {
        $padre = self::recursivo($this->padre);
        return "{$padre}<br/><strong style='color:#009AD6'>{$this->nombre}</strong>";
    }
    public function recursivo($data) {
        if(empty($data->padre))
            return "<strong style='color: {$data["color"]}'>{$data["nombre"]}</strong>";
        else
            return self::recursivo($data->padre) . "<br/>{$data["nombre"]}";
    }
}
