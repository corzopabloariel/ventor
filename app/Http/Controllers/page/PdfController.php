<?php

namespace App\Http\Controllers\page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mpdf\Mpdf;
use App\Pedido;
use App\ProductoVentor;
use App\PedidoProducto;
use App\Empresa;
use App\Cliente;
use App\Transporte;
use Cookie;

class PdfController extends Controller
{
    public function getPedido() {
        $pedido_id = Cookie::get("pedido");
        $pedido = Pedido::find($pedido_id);
        $productos = $pedido->hijos;
        $empresa = Empresa::first();
        $empresa["images"] = json_decode($empresa["images"], true);
        $data = [];
        $data["transporte"] = Transporte::find($pedido["transporte_id"]);
        $data["cliente"] = $pedido->cliente;
        $data["empresa"] = $empresa;
        $data["pedido"] = $pedido;
        $data["productos"] = $productos;

        $cliente = Cliente::find($pedido["cliente_id"]);
        $codVendedor = 44; // DIRECTA-Zona Centro
        if(!empty($pedido["vendedor_id"])) {
            $vendedor = Vendedor::find($pedido["vendedor_id"]);
            $codVendedor = $vendedor["vnddor"];
        }
        $codCliente = $cliente["nrocta"];
        $fecha = date("Ymd-His",strtotime($pedido["autofecha"]));
        $data["title"] = "Pedido {$codVendedor}-{$codCliente}-{$pedido_id}-{$fecha} Cliente {$codCliente}";

        $html = view('page.pdf.pedido',$data)->render();

        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
 
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = new Mpdf([
            "format" => "A4-L",
        ]);
        // $mpdf->SetTopMargin(5);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        // dd($mpdf);
        
        return $mpdf->Output("{$data["title"]}.pdf","D");
        //return $data["title"];
    }
}
