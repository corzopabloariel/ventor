<?php

namespace App\Http\Controllers\adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contenido;
class ContenidoController extends Controller
{
    public $idioma = "es";

    public function edit($seccion) {
        $contenido = Contenido::where("seccion",$seccion)->first();
        $view = "adm.parts.contenido.edit";
        if(empty($contenido)) {
            $ARR_data = [
                "seccion" => $seccion,
                "data" => null
            ];
            switch($seccion) {
                //PAGE - solo modifica la aparición de elementos en la vista, excepto header y footer
                case "home":
                    $ARR_data["data"] = [];
                    $ARR_data["data"]["PAGE"] = ["slider","marcas","familias","buscador","ofertas","entrega"];
                    $ARR_data["data"]["CONTENIDO"] = [];
                    $ARR_data["data"]["CONTENIDO"]["texto"] = null;
                    $ARR_data["data"]["CONTENIDO"]["image"] = null;
                    break;
                case "empresa":
                    $ARR_data["data"] = [];
                    $ARR_data["data"]["PAGE"] = ["slider"];
                    $ARR_data["data"]["CONTENIDO"] = [];
                    $ARR_data["data"]["CONTENIDO"][$this->idioma] = [];
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["texto"] = null;
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["numeros"] = [];
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["fechas"] = [];
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["vision"] = null;
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["mision"] = null;
                    break;
                case "calidad":
                    $ARR_data["data"] = [];
                    $ARR_data["data"]["PAGE"] = [];
                    $ARR_data["data"]["CONTENIDO"] = [];
                    $ARR_data["data"]["CONTENIDO"][$this->idioma] = [];
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["principal"] = [];
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["calidad"] = [];
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["garantia"] = [];
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["principal"]["titulo"] = null;
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["principal"]["subtitulo"] = null;
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["principal"]["texto"] = null;
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["principal"]["slogan"] = null;
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["calidad"]["titulo"] = null;
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["calidad"]["texto"] = null;
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["garantia"]["titulo"] = null;
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["garantia"]["texto"] = null;
                    break;
                case "pagos":
                    $ARR_data["data"] = [];
                    $ARR_data["data"]["PAGE"] = ["slider"];
                    $ARR_data["data"]["CONTENIDO"] = [];
                    $ARR_data["data"]["CONTENIDO"]["titulo"] = null;
                    $ARR_data["data"]["CONTENIDO"]["texto"] = null;
                    break;
                case "terminos":
                    $ARR_data["data"] = [];
                    $ARR_data["data"]["CONTENIDO"] = [];
                    $ARR_data["data"]["CONTENIDO"][$this->idioma] = [];
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["titulo"] = null;
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["texto"] = null;
                    break;
            }
            $ARR_data["data"] = json_encode($ARR_data["data"]);
            $contenido = Contenido::create($ARR_data);
        }
        $contenido["data"] = json_decode($contenido["data"], true);
        
        $title = "Contenido: " . strtoupper($seccion);
        return view('adm.distribuidor',compact('title','view','contenido','seccion'));
    }
    public function update(Request $request, $seccion) {
        $datosRequest = $request->all();
        $contenido = Contenido::where('seccion',$seccion)->first();
        //dd($datosRequest);
        $contenido["data"] = json_decode($contenido["data"], true);
        $ARR_data = [];
        $ARR_data["data"] = [];
        $ARR_data["data"]["CONTENIDO"] = [];
        switch($seccion) {
            case "home":
                $ARR_data["data"]["CONTENIDO"]["texto"] = [];
                $ARR_data["data"]["CONTENIDO"]["image"] = $contenido["data"]["CONTENIDO"]["image"];
                $ARR_data["data"]["CONTENIDO"]["texto"][$this->idioma] = $datosRequest["texto_{$this->idioma}"];
                $ARR_data["data"]["PAGE"] = $datosRequest["page"];
                
                $file = $request->file("image");
                if(!is_null($file)) {
                    $path = public_path('images/contenido/')."{$seccion}";
                    if (!file_exists($path))
                        mkdir($path, 0777, true);
                    $imageName = time()."_{$seccion}.".$file->getClientOriginalExtension();
                    
                    $file->move($path, $imageName);
                    $ARR_data["data"]["CONTENIDO"]["image"] = "images/contenido/{$seccion}/{$imageName}";
                    
                    if(!is_null($contenido["data"]["CONTENIDO"]["image"])) {
                        $filename = public_path() . "/{$contenido["data"]["CONTENIDO"]["image"]}";
                        if (file_exists($filename))
                            unlink($filename);
                    }
                }
                break;
            case "empresa":
                $ARR_data["data"]["PAGE"] = $datosRequest["page"];
                $ARR_data["data"]["CONTENIDO"] = [];
                $ARR_data["data"]["CONTENIDO"][$this->idioma] = [];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["texto"] = $datosRequest["texto_{$this->idioma}"];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["numeros"] = [];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["fechas"] = [];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["vision"] = [
                    "TIT" => $datosRequest["TIT_vision_{$this->idioma}"],
                    "TEX" => $datosRequest["vision_{$this->idioma}"]
                ];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["mision"] = [
                    "TIT" => $datosRequest["TIT_mision_{$this->idioma}"],
                    "TEX" => $datosRequest["mision_{$this->idioma}"]
                ];
                
                for( $i = 0 ; $i < count($datosRequest["anios_anio"]) ; $i++ )
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["fechas"][$datosRequest["anios_anio"][$i]] = $datosRequest["texto_anios"][$i];
                
                for( $i = 0 ; $i < count($datosRequest["numero_numero"]) ; $i++ ) {
                    $ARR_data["data"]["CONTENIDO"][$this->idioma]["numeros"][] = [
                        "N" => $datosRequest["numero_numero"][$i],
                        "T" => $datosRequest["texto_numero"][$i]
                    ];
                }
                break;
            case "calidad":
                $ARR_data["data"]["CONTENIDO"][$this->idioma] = [];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["principal"] = [];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["calidad"] = [];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["garantia"] = [];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["principal"]["titulo"] = $datosRequest["TIT_principal_{$this->idioma}"];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["principal"]["subtitulo"] = $datosRequest["SUBTIT_principal_{$this->idioma}"];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["principal"]["texto"] = $datosRequest["texto_principal_{$this->idioma}"];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["principal"]["slogan"] = $datosRequest["slogan_principal_{$this->idioma}"];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["calidad"]["titulo"] = $datosRequest["TIT_calidad_{$this->idioma}"];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["calidad"]["texto"] = $datosRequest["texto_calidad_{$this->idioma}"];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["garantia"]["titulo"] = $datosRequest["TIT_garantia_{$this->idioma}"];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["garantia"]["texto"] = $datosRequest["texto_garantia_{$this->idioma}"];
                break;
            case "terminos":
                $ARR_data["data"]["CONTENIDO"][$this->idioma] = [];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["titulo"] = $datosRequest["titulo_{$this->idioma}"];
                $ARR_data["data"]["CONTENIDO"][$this->idioma]["texto"] = $datosRequest["texto_{$this->idioma}"];
                break;
        }
        $contenido->fill(["data" => json_encode($ARR_data["data"])]);
        $contenido->save();

        return back();
    }
}