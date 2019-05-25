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
}
