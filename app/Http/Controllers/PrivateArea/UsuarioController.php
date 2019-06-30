<?php

namespace App\Http\Controllers\PrivateArea;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Usuario;
use App\Cliente;
use App\Vendedor;
use App\Empresa;
class UsuarioController extends Controller
{
    /** ---------------------------- */
    public function general() {
        $empresa = Empresa::first();
        $empresa["telefono"] = json_decode($empresa["telefono"], true);
        $empresa["domicilio"] = json_decode($empresa["domicilio"], true);
        $empresa["email"] = json_decode($empresa["email"], true);
        $empresa["metadatos"] = json_decode($empresa["metadatos"], true);
        $empresa["images"] = json_decode($empresa["images"], true);
        $empresa["redes"] = json_decode($empresa["redes"], true);
        return $empresa;
    }

    public function datos() {
        //$dataRequest = $request->all();
        if(auth()->guard('client')->user()["username"] == "111")
            return redirect("/");
        $title = "MIS DATOS";
        $view = "page.parts.datos";
        $datos = [];
        $datos["empresa"] = self::general();

        $data = [];
        $datos["datos"] = auth()->guard('client')->user();
        if($datos["datos"]["is_vendedor"] == 0)
            $datos["cliente"] = Cliente::where("nrodoc",$datos["datos"]["username"])->first();
        else if($datos["datos"]["is_vendedor"] == 1) {
            $aux = $datos["datos"]["username"];
            $aux = str_replace("VND_","",$aux);
            $datos["vendedor"] = Vendedor::where("natmer",$aux)->first();
        } else {
            $datos["empleado"] = Usuario::where("username",$datos["datos"]["username"])->first();
        }

        return view('page.distribuidor',compact('title','view','datos'));
    }

    public function mark(Request $request) {
        $dataRequest = $request->all();
        $data = Usuario::find(auth()->guard('client')->user()["id"]);

        $data->fill(["descuento" => $dataRequest["utilidad"]]);
        $data->save();
        return 1;
    }

    public function transporteCliente($id) {
        $aux = Cliente::find($id);
        return $aux["transporte_id"];
    }
}
