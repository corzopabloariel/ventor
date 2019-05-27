<?php

namespace App\Http\Controllers\page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormController extends Controller
{
    public function index(Request $request, $seccion) {
        $datosRequest = $request->all();
        unset($datosRequest["_method"]);
        unset($datosRequest["_token"]);
        self::$seccion($datosRequest);

        return back();
    }

    public function transmision($data) {
        dd($data);
    }
    public function pagos($data) {
        dd($data);
    }
    public function consulta($data) {
        dd($data);
    }
    public function trabaje($data) {
        dd($data);
    }
    public function contacto($data) {
        dd($data);
    }
}
