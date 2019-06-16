<?php

namespace App\Http\Controllers\adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exports\PedidoExport;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoM;

use Excel;
use App\Pedido;
use App\Transporte;
use App\Vendedor;
use App\Cliente;
use Cookie;
use DB;
use Redirect;

class AdmController extends Controller
{
    public function index() {
        $title = "Administración";
        $view = "adm.parts.index";
        return view('adm.distribuidor',compact('title', 'view'));
    }
    
    /** */
    public function logout() {
        Auth::logout();
    	return redirect()->to('/adm');
    }


    public function export($tipo = null) {
        $archivo = Excel::download(new PedidoExport, 'PEDIDO.xls');
        $pedido_id = Cookie::get("pedido");

        $pedido = Pedido::find($pedido_id);
        $transporte = Transporte::find($pedido["transporte_id"]);
        $cliente = Cliente::find($pedido["cliente_id"]);
        $codVendedor = 44; // DIRECTA-Zona Centro
        if(!empty($pedido["vendedor_id"])) {
            $vendedor = Vendedor::find($pedido["vendedor_id"]);
            $codVendedor = $vendedor["vnddor"];
        }
        $traCod = $transporte["tracod"] < 10 ? "0{$transporte["tracod"]}" : $transporte["tracod"];
        $codCliente = $cliente["nrocta"];
        $fecha = date("Ymd-His");
        $title = "Pedido {$codVendedor}-{$codCliente}-{$pedido_id}-{$fecha} Cliente {$codCliente}";

        $mensaje = [];
        $mensaje[] = "<&TEXTOS>{$pedido["observaciones"]}</&TEXTOS>";
        $mensaje[] = "<&TRACOD>{$traCod}|{$transporte["descrp"]} {$transporte["tradir"]}</&TRACOD>";
        
        Mail::to('corzo.pabloariel@gmail.com')
            ->send(
                new PedidoM(
                    $mensaje,
                    $title,
                    Excel::download(
                        new PedidoExport, 
                            'PEDIDO.xls'
                        )->getFile(), ['as' => 'PEDIDO.xls'])
            );
        /*Mail::to('pedidos.ventor@gmx.com')
            ->send(
                new PedidoM(
                    $mensaje,
                    $title,
                    Excel::download(
                        new PedidoExport, 
                            'PEDIDO.xls'
                        )->getFile(), ['as' => 'PEDIDO.xls'])
            );*/
        if(empty($tipo))
            return redirect()->route('indexADM');
        else
            return redirect()->route('pedido');
    }
}
