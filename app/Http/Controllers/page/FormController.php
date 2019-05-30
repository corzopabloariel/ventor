<?php

namespace App\Http\Controllers\page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Transmision;
use App\Mail\Pago;
use App\Mail\Consulta;
use App\Mail\Contacto;
use App\Email;

class FormController extends Controller
{
    public function index(Request $request, $seccion) {
        $datosRequest = $request->all();
        unset($datosRequest["_method"]);
        unset($datosRequest["_token"]);

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
    public function trabaje($data) {
        dd($data);
    }
    public function contacto($data) {
        
        $email = Email::where("formulario","contacto")->first();

        if(empty($data["g-recaptcha-response"]))
            return back()->withInput($data)->withErrors(['mssg' => "Captcha no seleccionado"]);

        if(!isset($data["terminos"]))
            return back()->withInput($data)->withErrors(['mssg' => "Acepte los términos y condiciones"]);
        
        Mail::to('corzo.pabloariel@gmail.com')->send(new Contacto($data));
        Mail::to($email["email"])->send(new Contacto($data));
        
        if (count(Mail::failures()) > 0)
            return back()->withErrors(['mssg' => "Ha ocurrido un error al enviar el correo"]);
        else
            return back()->withSuccess(['mssg' => "Correo enviado correctamente"]);
    }
}
