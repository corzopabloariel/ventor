<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartesVentor extends Model
{
    protected $table = "partesventor";
    protected $fillable = [
        'cod',
        'descrp',
        'familia_id'
    ];
    public function familia()
    {
        return $this->belongsTo('App\FamiliaVentor');
    }

    public function productos()
    {
        return $this->hasMany('App\ProductoVentor')->orderBy('stmpdh_art');
    }
    
    public function padre()
    {
        return $this->belongsTo('App\FamiliaVentor');
    }
}
