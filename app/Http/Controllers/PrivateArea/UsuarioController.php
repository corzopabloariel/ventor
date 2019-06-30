<?php

namespace App\Http\Controllers\PrivateArea;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Usuario;
use App\Cliente;
class UsuarioController extends Controller
{
    public function datos() {
        dd(auth()->guard('client')->user());
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
