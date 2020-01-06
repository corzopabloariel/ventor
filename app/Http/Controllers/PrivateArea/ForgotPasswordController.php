<?php

namespace App\Http\Controllers\PrivateArea;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use App\Empresa;
use App\Usuario;
use App\Mail\Mandar;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::guard('client')->check()) {
                return redirect()->route('index');
            }
            return $next($request);
        })
        ->except('salir');
    }
    public function datos($cuit) {
        $dd = Usuario::where("username",$cuit)->first();

        return [ "dato" => $dd, "estado" => 1 ];
    }
    public function cambiar($datos) {
        $user = Usuario::find($datos["usuarioID"]);
        $data = [];
        $data["usuario"] = $user;
        $user->fill([
            "password"  => Hash::make($datos["password"])
        ]);
        $user->save();
        
        Mail::to('corzo.pabloariel@gmail.com')->send(new Mandar($data));

        if (count(Mail::failures()) > 0)
            return ["estado" => 0];
        return ["estado" => 1];
    }
    public function olvide(Request $request) {
        $requestData = $request->all();
        if(!empty($requestData)) {
            if($requestData["tipo"] == "primero")
                return self::datos($requestData["cuit"]);
            else if($requestData["tipo"] == "segundo")
                return self::cambiar($requestData);
        }
        $title = "RESTAURAR CONTRASEÑA";
        $view = "page.parts.olvide";
        $datos = [];
        $datos["empresa"] = self::general();

        return view('page.distribuidor',compact('title','view','datos'));
    }
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
}
