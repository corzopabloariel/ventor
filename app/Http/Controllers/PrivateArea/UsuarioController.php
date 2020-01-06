<?php

namespace App\Http\Controllers\PrivateArea;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

use App\Usuario;
use App\Cliente;
use App\Vendedor;
use App\Empresa;
use App\Mail\Editar;
use App\Mail\Mandar;
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
    public function changepass(Request $request) {
        $dataRequest = $request->all();
        $usuario = auth()->guard('client')->user();
        if(!Hash::check($usuario["password"], $dataRequest["pass"]))
            return ["estado" => 0,"mssg" => "Contraseña incorrecta"];
        
        if($dataRequest["pass_1"] != $dataRequest["pass_2"])
            return ["estado" => 0,"mssg" => "Las contraseñas no coinciden"];

        if(!Hash::check($usuario["password"], Hash::make($dataRequest["pass_1"])))
            return ["estado" => 2,"mssg" => "La contraseña nueva es igual a la actual"];
        $data = [];
        $data["usuario"] = $usuario;
        $usuario->fill([
            "password"  => Hash::make($dataRequest["pass_1"])
        ]);
        $usuario->save();
        
        Mail::to('corzo.pabloariel@gmail.com')->send(new Mandar($data));

        if (count(Mail::failures()) > 0)
            return ["estado" => 0,"mssg" => "Ocurrió un error"];
        return ["estado" => 1];
    }
    public function datos(Request $request) {
        //$dataRequest = $request->all();
        if(!auth()->guard('client')->check()) return redirect()->route('index');
        if(auth()->guard('client')->user()["username"] == "0")
            return redirect("/");
        $dataRequest = $request->all();
        if(!empty($dataRequest)) {
            $data = [];
            unset($dataRequest["token"]);
            $data["cliente"] = auth()->guard('client')->user()->cliente;
            $data["datos"] = $dataRequest;
            Mail::to('corzo.pabloariel@gmail.com')->send(new Editar($data));

            if (count(Mail::failures()) > 0)
                return ["estado" => 0];
            return ["estado" => 1];
        }
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
