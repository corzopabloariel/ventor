<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Origen extends Model
{
    protected $table = "origenes";
    protected $fillable = [
        'nombre',
        'image'
    ];

    public function nombre() {
        $image = asset($this->image);
        return "{$this->nombre} <img src='{$image}' style='width: 34px;'/>";
    }
}
