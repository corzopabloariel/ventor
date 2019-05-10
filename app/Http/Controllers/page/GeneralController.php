<?php

namespace App\Http\Controllers\page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\Empresa;
use App\Slider;
use App\Categoria;
use App\Contenido;
use App\Producto;
use App\Descarga;
use App\Usuario;

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
    /**
     * @param $data []
     * @return []
     */
    public function menuRecursivo($data, $ids) {
        if(count($data) == 0)
            return [];
        else {
            $ARR = [];
            foreach($data AS $c) {
                $aux = [
                    "id" => $c["id"],
                    "nombre" => $c["nombre"],
                    "tipo" => $c["tipo"],
                    "hijos" => self::menuRecursivo($c["hijos"], $ids)
                ];
                if(in_array($c["id"], $ids))
                    $aux["active"] = 1;
                $ARR[] = $aux;
            }
            return $ARR;
        }
    }
    public function menu($ids) {
        $categorias = Categoria::whereNull("padre_id")->orderBy('orden')->get();
        $ARR = [];
        foreach($categorias AS $c) {
            $aux = [
                "id" => $c["id"],
                "color" => $c["color"],
                "nombre" => $c["nombre"],
                "tipo" => $c["tipo"],
                "hijos" => self::menuRecursivo($c->hijosTodos(), $ids)
            ];
            if(in_array($c["id"], $ids))
                $aux["active"] = 1;
            $ARR[] = $aux;
        }
        return $ARR;
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
    public function productos() {
        $title = "PRODUCTOS";
        $view = "page.parts.productos.index";
        $datos = [];
        $datos["empresa"] = self::general();
        $datos["categorias"] = Categoria::whereNull("padre_id")->orderBy('orden')->get();
        
        return view('page.distribuidor',compact('title','view','datos'));
    }
    public function producto($link = null) {
        if(empty($link))
            return redirect()->route('index');
        $title = "PRODUCTO : ";
        $view = "page.parts.productos.producto";
        $datos = [];
        $datos["empresa"] = self::general();
        $datos["producto"] = Producto::where("link",$link)->first();
        $title .= $datos["producto"]["nombre"];
        //dd($link);
        $datos["categoria"] = Categoria::find($datos["producto"]["categoria_id"]);
        $datos["menu"] = self::menu($datos["categoria"]->padres());
        $datos["nombres"] = $datos["categoria"]->padres(0);
        $datos["nombres"][] = ["nombre" => $datos["categoria"]["nombre"], "id" => $datos["categoria"]["id"]];

        return view('page.distribuidor',compact('title','view','datos'));
    }
    public function familia($id = null) {
        if(empty($id))
            return redirect()->route('index');
        $title = "PRODUCTOS";
        $view = "page.parts.productos.familia";
        $datos = [];
        $datos["empresa"] = self::general();
        $datos["categoria"] = Categoria::find($id);
        $datos["categorias"] = Categoria::where("padre_id",$id)->orderBy('orden')->get();
        $datos["menu"] = self::menu($datos["categoria"]->padres());
        $datos["nombres"] = $datos["categoria"]->padres(0);
        $datos["productos"] = $datos["categoria"]->productos;
//dd($datos["productos"]);//
        foreach($datos["productos"] AS $p)
            $p["modelo"] = $p->marca->getNombreEnteroAttribute(0);

        return view('page.distribuidor',compact('title','view','datos'));
    }
    public function calidad() {
        $title = "CALIDAD";
        $view = "page.parts.calidad";
        $datos = [];
        $datos["empresa"] = self::general();

        $datos["contenido"] = json_decode(Contenido::where("seccion","calidad")->first()["data"], true)["CONTENIDO"][$this->idioma];
        //dd($datos["contenido"]);
        return view('page.distribuidor',compact('title','view','datos'));
    }
    public function descargas() {
        $title = "DESCARGAS";
        $view = "page.parts.descargas";
        $datos = [];
        $datos["empresa"] = self::general();

        $datos["descargas"] = Descarga::orderBy("orden")->get();
        //dd($datos["contenido"]);
        return view('page.distribuidor',compact('title','view','datos'));
    }
    public function atencion($id = null) {
        if(empty($id))
            return redirect()->route('index');
        $title = "ATENCIÓN AL CLIENTE";
        $view = "page.parts.atencion.{$id}";
        $datos = [];
        $datos["empresa"] = self::general();
        return view('page.distribuidor',compact('title','view','datos'));
    }

    public function trabaje() {
        $title = "TRABAJE CON NOSOTROS";
        $view = "page.parts.trabaje";
        $datos = [];
        $datos["empresa"] = self::general();
        return view('page.distribuidor',compact('title','view','datos'));
    }
    
    public function registro() {
        $title = "REGISTRO";
        $view = "page.parts.registro";
        $datos = [];
        $datos["empresa"] = self::general();
        return view('page.distribuidor',compact('title','view','datos'));
    }
    public function registroUSER(Request $request) {
        $requestData = $request->all();
        $ARR_data = [];

        $aux = Usuario::where("username",$requestData["username"])->orWhere("email",$requestData["email"])->first();
        
        if(!empty($aux)) {

            return back()
                        ->withErrors(['mssg' => "Datos en uso [Usuario o Email]"])
                        ->withInput($requestData);
        }

        $ARR_data["name"] = $requestData["nombre"];
        $ARR_data["lastname"] = $requestData["apellido"];
        $ARR_data["username"] = $requestData["username"];
        $ARR_data["password"] = Hash::make($requestData["password"]);
        $ARR_data["email"] = $requestData["email"];

        Usuario::create($ARR_data);
        return back()->withSuccess(['mssg' => "Usuario creado correctamente"]);
    }

    public function pedido() {
        
        $title = "PEDIDO";
        $view = "page.parts.pedido";
        $datos = [];
        $datos["empresa"] = self::general();
        $datos["productos"] = Producto::orderBy("orden")->get();
        return view('page.distribuidor',compact('title','view','datos'));
    }
    
    public function carrito() {
        
        $title = "CARRITO";
        $view = "page.parts.pedido";
        $datos = [];
        $datos["empresa"] = self::general();
        $datos["carrito"] = 1;
        $datos["productos"] = Producto::orderBy("orden")->get();
        return view('page.distribuidor',compact('title','view','datos'));
    }
}
