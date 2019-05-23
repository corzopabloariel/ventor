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
}
