<?php

namespace App\Http\Controllers\page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Cookie;
use Illuminate\Support\Facades\DB;

use App\Empresa;
use App\Cliente;
use App\Slider;
use App\Categoria;
use App\PartesVentor;
use App\Contenido;
use App\Producto;
use App\Descarga;
use App\Usuario;
use App\Recurso;
use App\ProductoVentor;
use App\Numero;
use App\Pedido;
use App\PedidoProducto;
use App\Novedad;
class GeneralController extends Controller
{
    public $idioma = "es";
    public $paginate = 6;
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
    /*public function salir() {
        Auth('client')::logout();
        return redirect()->route('index');
    }*/
    /**
     * @param $data []
     * @return []
     */
    public function menuRecursivo($data, $ids) {
        if(count($data) == 0)
            return [];
        else {
            $ARR = [];
            foreach($data AS $c) {
                $aux = [
                    "id" => $c["id"],
                    "nombre" => $c["descrp"],
                    //"tipo" => $c["tipo"],
                    "hijos" => []
                ];
                if(in_array($c["id"], $ids))
                    $aux["active"] = 1;
                $ARR[] = $aux;
            }
            return $ARR;
        }
    }
    public function menu($ids) {
        $categorias = Categoria::whereNull("padre_id")->orderBy('orden')->get();
        $ARR = [];
        foreach($categorias AS $c) {
            $aux = [
                "id" => $c["id"],
                "color" => $c["color"],
                "nombre" => $c["nombre"],
                "tipo" => $c["tipo"],
                "hijos" => self::menuRecursivo($c->familia->hijos, $ids)
            ];
            if(in_array($c["id"], $ids))
                $aux["active"] = 1;
            $ARR[] = $aux;
        }
        return $ARR;
    }
    public function buscador(Request $request, $tipo) {
        switch($tipo) {
            case "pedido":
            try {
                if(is_null($request->all()["buscar"]))
                    return redirect()->route('pedido');
                else {
                    $buscar = $request->all()["buscar"];
                    Cookie::queue("buscar", $buscar, 100);
                }
            } catch (\Throwable $th) {
                //throw $th;
                $buscar = Cookie::get("buscar");
            }   

            $data = Producto::where(function($query) use ($buscar) {
                            $query->where("productos.nombre", "LIKE", "%{$buscar}%");
                            $query->orWhere("productos.codigo", "LIKE", "%{$buscar}%");
                        })
                        ->leftJoin("marcas",function($join) use ($buscar) {
                            $join->on("marcas.id","=","productos.marca_id")
                                ->where("marcas.nombre", "LIKE", "%{$buscar}%");
                        })
                        ->select("productos.*")
                        ->orderBy("productos.nombre")->paginate($this->paginate);
            
            return self::pedido($data, ["buscar" => $buscar]);
            break;
        }
    }
    /** ---------------------------- */
    public function index() {
        $title = "HOME";
        $view = "page.parts.index";
        $datos = [];
        $datos["slider"] = Slider::where('seccion','home')->get();
        foreach($datos["slider"] AS $s)
            $s["texto"] = json_decode($s["texto"],true)[$this->idioma];
        $datos["empresa"] = self::general();
        $datos["categorias"] = Categoria::whereNull("padre_id")->orderBy('orden')->get();
        $datos["productos"] = Producto::where("novedad",1)->orderBy("orden")->get();
        $datos["novedades"] = Novedad::orderBy('orden')->get();
        
        return view('page.distribuidor',compact('title','view','datos'));
    }
    public function empresa() {
        $title = "EMPRESA";
        $view = "page.parts.empresa";
        $datos = [];
        $datos["slider"] = Slider::where('seccion','empresa')->get();
        foreach($datos["slider"] AS $s)
            $s["texto"] = json_decode($s["texto"],true)[$this->idioma];
        $datos["empresa"] = self::general();

        $datos["contenido"] = json_decode(Contenido::where("seccion","empresa")->first()["data"], true)["CONTENIDO"][$this->idioma];
        
        return view('page.distribuidor',compact('title','view','datos'));
    }
    public function productos() {
        $title = "PRODUCTOS";
        $view = "page.parts.productos.index";
        $datos = [];
        $datos["empresa"] = self::general();
        $datos["categorias"] = Categoria::whereNull("padre_id")->orderBy('orden')->get();
        
        return view('page.distribuidor',compact('title','view','datos'));
    }
    public function producto($link = null, $buscar = null) {
        if(empty($link))
            return redirect()->route('index');
        $title = "PRODUCTO : ";
        $view = "page.parts.productos.producto";
        $datos = [];
        $datos["empresa"] = self::general();
        $datos["producto"] = ProductoVentor::find($link);
        $title .= $datos["producto"]["stmpdh_tex"];
        //dd($link);
        $datos["categoria"] = PartesVentor::find($datos["producto"]["parte_id"]);
        
        $ids = $datos["categoria"]->familia->categoria->padres();
        $ids[] = $datos["producto"]["parte_id"];
        $datos["menu"] = self::menu($ids);
        
        $datos["nombres"] = $datos["categoria"]->familia->categoria->padres(0);
        $datos["nombres"][] = ["nombre" => $datos["categoria"]["descrp"], "id" => $datos["categoria"]["id"], "parte" => 1];

        return view('page.distribuidor',compact('title','view','datos'));
    }
    public function familia($id = null, $tipo = null) {
        if(empty($id))
            return redirect()->route('index');
        $title = "PRODUCTOS";
        $view = "page.parts.productos.familia";
        $datos = [];
        $datos["empresa"] = self::general();
        if(empty($tipo)) {
            $datos["categoria"] = Categoria::find($id);
            $datos["categorias"] = Categoria::where("padre_id",$id)->orderBy('orden')->get();
            $datos["menu"] = self::menu($datos["categoria"]->padres());
            $datos["nombres"] = $datos["categoria"]->padres(0);

            $datos["productos"] = ProductoVentor::where("familia_id",$datos["categoria"]->familia["id"])->paginate(15);
        } else {
            $datos["categoria"] = PartesVentor::find($id);
            $datos["categorias"] = [];
            $ids = $datos["categoria"]->familia->categoria->padres();
            $ids[] = $id;
            $datos["menu"] = self::menu($ids);
            $datos["nombres"] = $datos["categoria"]->familia->categoria->padres(0);
            
            $datos["productos"] = ProductoVentor::where("parte_id",$id)->paginate(15);
        }

        return view('page.distribuidor',compact('title','view','datos'));
    }
    public function calidad() {
        $title = "CALIDAD";
        $view = "page.parts.calidad";
        $datos = [];
        $datos["empresa"] = self::general();

        $datos["contenido"] = json_decode(Contenido::where("seccion","calidad")->first()["data"], true)["CONTENIDO"][$this->idioma];
        //dd($datos["contenido"]);
        return view('page.distribuidor',compact('title','view','datos'));
    }
    public function descargas() {
        $title = "DESCARGAS";
        $view = "page.parts.descargas";
        $datos = [];
        $datos["empresa"] = self::general();

        if(auth()->guard('client')->check()) {
            $datos["descargas"] = Descarga::where("privado",1)->orderBy("orden")->get();
            $datos["descargasO"] = Descarga::where("privado",1)->where("otras",1)->orderBy("orden")->get();
            $datos["privado"] = 1;
        } else {
            $datos["descargas"] = Descarga::where("privado",0)->orderBy("orden")->get();
            $datos["descargasP"] = Descarga::where("privado",1)->where("otras",0)->orderBy("orden")->get();
            $datos["descargasO"] = Descarga::where("privado",1)->where("otras",1)->orderBy("orden")->get();
        }
        //dd($datos["contenido"]);
        return view('page.distribuidor',compact('title','view','datos'));
    }
    public function atencion($id = null) {
        if(empty($id))
            return redirect()->route('index');
        $title = "ATENCIÓN AL CLIENTE";
        $view = "page.parts.atencion.{$id}";
        $datos = [];
        $datos["empresa"] = self::general();
        return view('page.distribuidor',compact('title','view','datos'));
    }

    public function trabaje() {
        $title = "TRABAJE CON NOSOTROS";
        $view = "page.parts.trabaje";
        $datos = [];
        $datos["trabajos"] = Recurso::orderBy("orden")->get();
        $datos["empresa"] = self::general();
        return view('page.distribuidor',compact('title','view','datos'));
    }

    public function contacto() {
        $title = "CONTACTO";
        $view = "page.parts.contacto";
        $datos = [];
        $datos["empresa"] = self::general();
        
        $datos["numeros"] = Numero::orderBy("orden")->get();
        return view('page.distribuidor',compact('title','view','datos'));
    }
    
    public function registro() {
        $title = "REGISTRO";
        $view = "page.parts.registro";
        $datos = [];
        $datos["empresa"] = self::general();
        return view('page.distribuidor',compact('title','view','datos'));
    }
    public function soap($ipC) {
        $msserver="192.168.0.9";
        $msserver="200.117.254.149:9090";

        $msserver="ventorsa.no-ip.info:9090";

        $msserver="ventorsa1.no-ip.info:9090";
        $msserver="24.232.33.120:9090";
        //$msserver="190.17.239.18:9090";
        //$msserver="ventorsa1.no-ip.info:9090";
        $msserver="181.170.160.91:9090";

        $proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
        $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
        $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
        $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';

        //$_REQUEST["idC"] = str_replace('@',' ',$_REQUEST["idC"]);

        $param = array('$ARTCOD;0019', 'Test', 'c2d*-f', '1');
        $param = array( "pSPName" => "ConsultaStock", "pParamList" => '$ARTCOD;' . $ipC, "pUserId" => "Test", "pPassword" => "c2d*-f",  "pGenLog" => "1");

        //$client = new SoapClient('http://'.$msserver.'/dotWSUtils/WSUtils.asmx?WSDL', $param);
        $client = new \nusoap_client('http://'.$msserver.'/dotWSUtils/WSUtils.asmx?WSDL', 'wsdl');

        //dd($client);
        $result = $client->call('EjecutarSP_String', $param, '', '', false, true);

        // Check for a fault
        if ($client->fault) {
            echo 'error al conectar';
        } else {

            // Check for errors
            $err = $client->getError();
            if ($err) {
                // Display the error
                echo 'error de ejecucion ';
            } else {
                $cadena = explode(",", $result["EjecutarSP_StringResult"]);
            
                if ($cadena[2] > 0 )echo "1@".$cadena[2];
                else echo "3@".$cadena[2];
            }
        }
    }

    public function productoSHOW($id) {
        $data = ProductoVentor::find($id);
        $data["image"] = asset("IMAGEN/{$data["codigo_ima"][0]}/{$data["codigo_ima"]}.jpg");
        $data["parte_id"] = $data->parte_id();
        $data["precioF"] = $data->getPrecio();
        return $data;
    }

    public function pedido(Request $request) {
        
        $title = "PEDIDO";
        $view = "page.parts.pedido";
        $datos = [];
        $buscar = null;
        $datos["empresa"] = self::general();
        if(!empty($request->all()["buscar"])) {
            $buscar = $request->all()["buscar"];
            $datos["productos"] = ProductoVentor::where("stmpdh_art","LIKE","%{$buscar}%")->orWhere("stmpdh_tex","LIKE","%{$buscar}%")->orderBy("stmpdh_art")->paginate($this->paginate);
        } else
        $datos["productos"] = ProductoVentor::orderBy("stmpdh_art")->paginate($this->paginate);
        $datos["buscar"] = $buscar;
        //dd($datos);
        return view('page.distribuidor',compact('title','view','datos'));
    }

    public function pedidoCliente(Request $request) {
        $data = $request->all();
        
        $data["pedido"] = json_decode($data["pedido"], true);
        
        $usuario = Usuario::find($data["idUsuario"]);
        $cliente = Cliente::where("nrodoc",$usuario["username"])->first();

        $Arr_data = [];
        $Arr_data["is_adm"] = 2;
        
        $Arr_data["usuario_id"] = NULL;
        $Arr_data["transporte_id"] = NULL;
        $Arr_data["cliente_id"] = $cliente["id"];
        $Arr_data["estado"] = 0;
        $Arr_data["observaciones"] = $data["observaciones"];
        
        $pedido = Pedido::create($Arr_data);
        $pedido_id = $pedido["id"];
        //dd($pedido_id);
        foreach($data["pedido"] AS $id => $val) {
            if($id == "TOTAL") continue;
            $Arr_p = [];
            $Arr_p["pedido_id"] = $pedido_id;
            $Arr_p["producto_id"] = $id;
            $Arr_p["cnt"] = $val["cantidad"];
            $Arr_p["observ"] = "0";
            
            PedidoProducto::create($Arr_p);
        }
        return 1;
    }
    
    public function carrito() {
        
        $title = "CARRITO";
        $view = "page.parts.pedido";
        $datos = [];
        $datos["empresa"] = self::general();
        $datos["carrito"] = 1;
        $datos["productos"] = [];
        return view('page.distribuidor',compact('title','view','datos'));
    }
}
