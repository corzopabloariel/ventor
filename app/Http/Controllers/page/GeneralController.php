<?php

namespace App\Http\Controllers\page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Empresa;
use App\Slider;
use App\Categoria;
use App\Contenido;

class GeneralController extends Controller
{
    public $idioma = "es";
    /** ---------------------------- */
    public function general() {
        $empresa = Empresa::first();
        $empresa["telefono"] = json_decode($empresa["telefono"], true);
        $empresa["domicilio"] = json_decode($empresa["domicilio"], true);
        $empresa["email"] = json_decode($empresa["email"], true);
        $empresa["metadatos"] = json_decode($empresa["metadatos"], true);
        $empresa["images"] = json_decode($empresa["images"], true);
        //$empresa["redes"] = json_decode($empresa["redes"], true);
        return $empresa;
    }
    /** ---------------------------- */
    public function index() {
        $title = "HOME";
        $view = "page.parts.index";
        $datos = [];
        $datos["slider"] = Slider::where('seccion','home')->get();
        foreach($datos["slider"] AS $s)
            $s["texto"] = json_decode($s["texto"],true)[$this->idioma];
        $datos["empresa"] = self::general();
        $datos["categorias"] = Categoria::whereNull("padre_id")->orderBy('orden')->get();
        
        return view('page.distribuidor',compact('title','view','datos'));
    }
    public function empresa() {
        $title = "EMPRESA";
        $view = "page.parts.empresa";
        $datos = [];
        $datos["slider"] = Slider::where('seccion','empresa')->get();
        foreach($datos["slider"] AS $s)
            $s["texto"] = json_decode($s["texto"],true)[$this->idioma];
        $datos["empresa"] = self::general();

        $datos["contenido"] = json_decode(Contenido::where("seccion","empresa")->first()["data"], true)["CONTENIDO"][$this->idioma];
        //dd($datos["contenido"]);
        return view('page.distribuidor',compact('title','view','datos'));
    }
}
