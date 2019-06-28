<?php

namespace App\Http\Controllers\page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Transmision;
use App\Mail\Trabajo;
use App\Mail\Pago;
use App\Mail\Consulta;
use App\Mail\Contacto;
use App\Email;

class FormController extends Controller
{
    public $secret = "6LeFv6IUAAAAAPY4fMwTKKJ957JoVkMoaANobzvm";

    public function index(Request $request, $seccion) {
        $datosRequest = $request->all();
        unset($datosRequest["_method"]);
        unset($datosRequest["_token"]);
        
        if($seccion == "trabaje")
            return self::$seccion($request, $datosRequest, $request->file('curriculum'));
        else
            return self::$seccion($datosRequest);
        /**
         * ATENCIÓN AL CLIENTE: atencionalcliente@ventor.com.ar
         * INFORMACIÓN DE PAGOS: cuentascorrientes@ventor.com.ar
         * CONSULTA GENERAL: atencionalcliente@ventor.com.ar
         * TRABAJE CON NOSOTROS: recursoshumanos@ventor.com.ar
         * CONTACTO: 
         */
    }

    public function transmision($data) {

        $email = Email::where("formulario","atencion")->first();
        
        Mail::to('corzo.pabloariel@gmail.com')->send(new Transmision($data));
        Mail::to($email["email"])->send(new Transmision($data));
        
        if (count(Mail::failures()) > 0)
            return back()->withErrors(['mssg' => "Ha ocurrido un error al enviar el correo"]);
        else
            return back()->withSuccess(['mssg' => "Correo enviado correctamente"]);
    }
    public function pagos($data) {
        $email = Email::where("formulario","pagos")->first();

        if(empty($data["g-recaptcha-response"]))
            return back()->withInput($data)->withErrors(['mssg' => "Captcha no seleccionado"]);

        if(!isset($data["terminos"]))
            return back()->withInput($data)->withErrors(['mssg' => "Acepte los términos y condiciones"]);
        
        Mail::to('corzo.pabloariel@gmail.com')->send(new Pago($data));
        Mail::to($email["email"])->send(new Pago($data));
        
        if (count(Mail::failures()) > 0)
            return back()->withErrors(['mssg' => "Ha ocurrido un error al enviar el correo"]);
        else
            return back()->withSuccess(['mssg' => "Correo enviado correctamente"]);
    }
    public function consulta($data) {
        
        $email = Email::where("formulario","consulta")->first();

        if(empty($data["g-recaptcha-response"]))
            return back()->withInput($data)->withErrors(['mssg' => "Captcha no seleccionado"]);

        if(!isset($data["terminos"]))
            return back()->withInput($data)->withErrors(['mssg' => "Acepte los términos y condiciones"]);
        
        Mail::to('corzo.pabloariel@gmail.com')->send(new Consulta($data));
        Mail::to($email["email"])->send(new Consulta($data));
        
        if (count(Mail::failures()) > 0)
            return back()->withErrors(['mssg' => "Ha ocurrido un error al enviar el correo"]);
        else
            return back()->withSuccess(['mssg' => "Correo enviado correctamente"]);
    }
    public function trabaje($request, $data, $archivo) {
        //dd($archivo);
        $email = Email::where("formulario","trabaje")->first();
        //Mail::to($mandar)->send(new Contacto($data));
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$this->secret}&response={$data["g-recaptcha-response"]}&remoteip=".$_SERVER['REMOTE_ADDR']);
        $response = json_decode($response, true);

        //if($response["success"] == false)
            //return back()->withErrors(['mssg' => "Ha ocurrido un error de captcha"]);
        
        Mail::to('corzo.pabloariel@gmail.com')->send(new Trabajo($data, $archivo));
        Mail::to('ventor@ventor.com.ar')->send(new Trabajo($data, $archivo));
        Mail::to($email["email"])->send(new Trabajo($data, $archivo));
        if (count(Mail::failures()) > 0)
            return back()->withErrors(['mssg' => "Ha ocurrido un error al enviar el correo"]);
        else
            return back()->withSuccess(['mssg' => "Correo enviado correctamente"]);
    }
    public function contacto($data) {
        $mandar = $data["mandar"];
        $email = Email::where("formulario","contacto")->first();

        if(empty($data["g-recaptcha-response"]))
            return back()->withInput($data)->withErrors(['mssg' => "Captcha no seleccionado"]);

        if(!isset($data["terminos"]))
            return back()->withInput($data)->withErrors(['mssg' => "Acepte los términos y condiciones"]);
        
        Mail::to('corzo.pabloariel@gmail.com')->send(new Contacto($data));
        Mail::to($mandar)->send(new Contacto($data));
        
        if (count(Mail::failures()) > 0)
            return back()->withErrors(['mssg' => "Ha ocurrido un error al enviar el correo"]);
        else
            return back()->withSuccess(['mssg' => "Correo enviado correctamente"]);
    }
}
