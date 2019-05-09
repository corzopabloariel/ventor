<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'orden',
        'codigo',
        'nombre',
        'image',
        'catalogo',
        'link',
        'mercadolibre',
        'cantidad',
        'familia_id',
        'categoria_id',
        'origen_id',
        'marca_id'
    ];
    
    public function categoria()
    {
        return $this->belongsTo('App\Categoria');
    }
    public function marca()
    {
        return $this->belongsTo('App\Marca');
    }
    public function getNombreCodigoAttribute() {
        $orden = strtoupper($this->orden);
        return "{$this->nombre}<p class='mb-0'><small class='text-muted'>COD. {$this->codigo}</small></p><p class='mb-0'><small class='text-muted'>CANT. ENV. {$this->cantidad} | ORDEN: <span data-orden>{$orden}</span></small></p>";
    }
}
