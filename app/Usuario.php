<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $fillable = [
        'name',
        'lastname',
        'password',
        'email',
        'username',
        'descuento',
        'vendedor_id'
    ];

    public function nombre() {
        return "{$this->name} {$this->lastname}";
    }
    public function descuento() {
        return $this->descuento * 100;
    }
}
