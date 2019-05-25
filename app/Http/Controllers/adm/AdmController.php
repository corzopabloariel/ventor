<?php

namespace App\Http\Controllers\adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exports\PedidoExport;
use Illuminate\Support\Facades\Mail;
use App\Mail\Pedido;

use Excel;

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


    public function export() {
        $archivo = Excel::download(new PedidoExport, 'PEDIDO.xls');
        
        $mensaje = "lo que sea";
        Mail::to('corzo.pabloariel@gmail.com')
            ->send(
                new Pedido(
                    $mensaje,
                    Excel::download(
                        new PedidoExport, 
                            'PEDIDO.xls'
                        )->getFile(), ['as' => 'PEDIDO.xls'])
            );

        
    }
}
