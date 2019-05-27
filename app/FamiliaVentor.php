<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamiliaVentor extends Model
{
    protected $table = "familiasventor";
    protected $fillable = [
        'usr_stmati'
    ];

    public function hijos()
    {
        return $this->hasMany('App\PartesVentor','familia_id','id')->orderBy('descrp');
    }
    
    public function productos()
    {
        return $this->hasMany('App\ProductoVentor','familia_id','id')->orderBy('stmpdh_art');
    }

    public function categoria()
    {
        return $this->hasOne('App\Categoria','familia_id','id');
    }
}
