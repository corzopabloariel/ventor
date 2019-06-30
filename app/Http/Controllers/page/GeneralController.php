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
use App\Familiaparte;
use App\Transporte;
use App\Vendedor;
class GeneralController extends Controller
{
    public $idioma = "es";
    public $paginate = 15;
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
                "hijos" => []
            ];

            $partes = $c->partes;
            foreach($partes AS $p)
                $aux["hijos"] = array_merge($aux["hijos"],self::menuRecursivo($p->hijos, $ids));

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
                        ->orderBy("productos.nombre")->paginate($this->paginate)->onEachSide(5);
            
            return self::pedido($data, ["buscar" => $buscar]);
            break;
            case "body":
            $buscar = $request->all()["buscar"];
            if(empty($buscar)) 
                return back()->withInput($request->all())->withErrors(['mssg' => "La búsqueda no puede estar vacia"]);
            $title = "PRODUCTOS";
            $view = "page.parts.productos.buscar";
            $datos = [];
            $datos["empresa"] = self::general();
            $datos["productos"] = ProductoVentor::
                                where("stmpdh_art","LIKE","%{$buscar}%")->
                                orWhere("stmpdh_tex","LIKE","%{$buscar}%")->
                                    orderBy("marca")->paginate($this->paginate)->onEachSide(5);

            return view('page.distribuidor',compact('title','view','datos'));
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
        $ids = [];
        if(!empty($datos["categoria"]->familia->categoria))
            $ids = $datos["categoria"]->familia->categoria->padres();
        $ids[] = $datos["producto"]["parte_id"];
        $datos["menu"] = self::menu($ids);
        //dd($datos["menu"]);
        $datos["nombres"] = [];
        if(!empty($datos["categoria"]->familia->categoria))
            $datos["nombres"] = $datos["categoria"]->familia->categoria->padres(0);
        $datos["nombres"][] = ["nombre" => $datos["categoria"]["descrp"], "id" => $datos["categoria"]["id"], "parte" => 1];

        return view('page.distribuidor',compact('title','view','datos'));
    }
    public function familia(Request $request, $id = null, $tipo = null) {
        $dataRequest = $request->all();
        
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
            //dd($datos["menu"]);
            $datos["nombres"] = $datos["categoria"]->padres(0);
            
            $datos["para"] = ProductoVentor::where("familia_id",$datos["categoria"]->familia["id"])->orderBy("marca")->pluck("marca","marca_id");
            if(!isset($dataRequest["para"]))
                $datos["productos"] = ProductoVentor::where("familia_id",$datos["categoria"]->familia["id"])->paginate($this->paginate)->onEachSide(5);
            else {
                $datos["paraID"] = $dataRequest["para"];
                $datos["productos"] = ProductoVentor::where("familia_id",$datos["categoria"]->familia["id"])->where("marca_id",$dataRequest["para"])->paginate($this->paginate)->onEachSide(5);
            }
        } else {
            $datos["para"] = ProductoVentor::where("parte_id",$id)->orderBy("marca")->pluck("marca","marca_id");
            $datos["categoria"] = PartesVentor::find($id);
            $datos["categorias"] = [];
            $relAUX = $datos["categoria"]->familia;
            
            $aux = Familiaparte::where("familia_id",$relAUX["id"])->first();
            
            //$ids = $datos["categoria"]->familia->categoria->padres();
            $ids = [];
            $ids[] = $aux["categoria_id"];
            $ids[] = $id;
            //dd($ids);
            $datos["menu"] = self::menu($ids);
            //dd($datos["menu"]);
            $datos["nombres"] = [];
            $datos["nombres"][] = ["id" => $aux->categoria["id"], "nombre" => $aux->categoria["nombre"]];
            //dd();
            
            if(!isset($dataRequest["para"]))
                $datos["productos"] = ProductoVentor::where("parte_id",$id)->orderBy("marca")->paginate($this->paginate)->onEachSide(5);
            else {
                $datos["paraID"] = $dataRequest["para"];
                $datos["productos"] = ProductoVentor::where("parte_id",$id)->orderBy("marca")->where("marca_id",$dataRequest["para"])->paginate($this->paginate)->onEachSide(5);
            }
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
            $datos["descargasP"] = Descarga::where("privado",0)->orderBy("orden")->get();
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
        try {
            //$client = new SoapClient('http://'.$msserver.'/dotWSUtils/WSUtils.asmx?WSDL', $param);
            $client = new \nusoap_client('http://'.$msserver.'/dotWSUtils/WSUtils.asmx?WSDL', 'wsdl');
            $result = $client->call('EjecutarSP_String', $param, '', '', false, true);
            if ($client->fault) {
                echo -1;
            } else {
                $err = $client->getError();
                if ($err)
                    echo -2;
                else {
                    $cadena = explode(",", $result["EjecutarSP_StringResult"]);
                    if ($cadena[2] > 0 )
                        echo $cadena[2];
                    else
                        echo $cadena[2];
                }
            }
        } catch (\Throwable $th) {
            echo -3;
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
        if(!auth()->guard('client')->check()) return redirect()->route('index');
        $dataRequest = $request->all();
        $title = "PEDIDO";
        $view = "page.parts.pedido";
        $datos = [];
        $buscar = null;
        $para = null;
        $datos["menu"] = self::menu([]);
        $datos["empresa"] = self::general();
        if(auth()->guard('client')->user()["is_vendedor"] == 1) {
            $natmer = Auth::user()["username"];
            $natmer = str_replace("VND_","",$natmer);
            $vendedor = Vendedor::where("natmer",$natmer)->first();
            $usuarios = Usuario::where("vendedor_id",$vendedor["id"])->where("username","!=","111")->where("is_vendedor",0)->get();
            $clientes = Cliente::where("vendedor_id",$vendedor["id"])->where("nrodoc","!=","111")->get();
            foreach($clientes AS $c)
                $c["nombreX"] = "{$c["nrocta"]} {$c["nombre"]}";
            $datos["clientes"] = $clientes->pluck("nombreX","id");
        } else if(auth()->guard('client')->user()["is_vendedor"] == 2) {
            $clientes = Cliente::where("nrodoc","!=","111")->get();
            foreach($clientes AS $c)
                $c["nombreX"] = "[{$c["nrocta"]}] {$c["nombre"]}";
            $datos["clientes"] = $clientes->pluck("nombreX","id");
        }
        if(!empty($dataRequest["buscar"]) && empty($dataRequest["para"])) {
            $buscar = $dataRequest["buscar"];
            $datos["productos"] = ProductoVentor::where("stmpdh_art","LIKE","%{$buscar}%")->orWhere("stmpdh_tex","LIKE","%{$buscar}%")->orderBy("stmpdh_art")->paginate($this->paginate)->onEachSide(5);
        } else if(empty($dataRequest["buscar"]) && !empty($dataRequest["para"])) {
            $para = $dataRequest["para"];
            $datos["productos"] = ProductoVentor::where("parte_id",$dataRequest["para"])->orderBy("stmpdh_art")->paginate($this->paginate)->onEachSide(5);
        } else if(!empty($dataRequest["buscar"]) && !empty($dataRequest["para"])) {
            $buscar = $dataRequest["buscar"];
            $para = $dataRequest["para"];
            $datos["productos"] = ProductoVentor::where("stmpdh_art","LIKE","%{$buscar}%")->where("parte_id",$dataRequest["para"])->orWhere("stmpdh_tex","LIKE","%{$buscar}%")->where("parte_id",$dataRequest["para"])->orderBy("stmpdh_art")->paginate($this->paginate)->onEachSide(5);
        } else
            $datos["productos"] = ProductoVentor::orderBy("stmpdh_art")->paginate($this->paginate)->onEachSide(5);
        $datos["para"] = ProductoVentor::orderBy("marca")->pluck("marca","marca_id");
        
        $datos["buscar"] = $buscar;
        $datos["paraID"] = $para;
        
        return view('page.distribuidor',compact('title','view','datos'));
    }

    public function pedidoFamilia(Request $request, $id) {
        if(!auth()->guard('client')->check()) return redirect()->route('index');
        $title = "PEDIDO";
        $dataRequest = $request->all();
        $view = "page.parts.pedido";
        $datos = [];
        $buscar = $para = null;
        $datos["menu"] = self::menu([]);
        $datos["empresa"] = self::general();
        if(auth()->guard('client')->user()["is_vendedor"] == 1) {
            $natmer = Auth::user()["username"];
            $natmer = str_replace("VND_","",$natmer);
            $vendedor = Vendedor::where("natmer",$natmer)->first();
            $usuarios = Usuario::where("vendedor_id",$vendedor["id"])->where("username","!=","111")->where("is_vendedor",0)->get();
            $clientes = Cliente::where("vendedor_id",$vendedor["id"])->where("nrodoc","!=","111")->get();
            foreach($clientes AS $c)
                $c["nombreX"] = "{$c["nrocta"]} {$c["nombre"]}";
            $datos["clientes"] = $clientes->pluck("nombreX","id");
        } else if(auth()->guard('client')->user()["is_vendedor"] == 2) {
            $clientes = Cliente::where("nrodoc","!=","111")->get();
            foreach($clientes AS $c)
                $c["nombreX"] = "[{$c["nrocta"]}] {$c["nombre"]}";
            $datos["clientes"] = $clientes->pluck("nombreX","id");
        }
        if(!empty($dataRequest["buscar"]) && empty($dataRequest["para"])) {
            $buscar = $dataRequest["buscar"];
            $datos["productos"] = ProductoVentor::where("stmpdh_art","LIKE","%{$buscar}%")->orWhere("stmpdh_tex","LIKE","%{$buscar}%")->orderBy("stmpdh_art")->paginate($this->paginate)->onEachSide(5);
        } else if(empty($dataRequest["buscar"]) && !empty($dataRequest["para"])) {
            $para = $dataRequest["para"];
            $datos["productos"] = ProductoVentor::where("parte_id",$dataRequest["para"])->orderBy("stmpdh_art")->paginate($this->paginate)->onEachSide(5);
        } else if(!empty($dataRequest["buscar"]) && !empty($dataRequest["para"])) {
            $buscar = $dataRequest["buscar"];
            $para = $dataRequest["para"];
            $datos["productos"] = ProductoVentor::where("stmpdh_art","LIKE","%{$buscar}%")->where("parte_id",$dataRequest["para"])->orWhere("stmpdh_tex","LIKE","%{$buscar}%")->where("parte_id",$dataRequest["para"])->orderBy("stmpdh_art")->paginate($this->paginate)->onEachSide(5);
        } else
            $datos["productos"] = ProductoVentor::orderBy("stmpdh_art")->paginate($this->paginate)->onEachSide(5);
        $datos["para"] = ProductoVentor::orderBy("marca")->pluck("marca","marca_id");
        $datos["buscar"] = $buscar;
        $datos["paraID"] = $para;
        //dd($datos);
        $datos["categoria"] = Categoria::find($id);
        $datos["menu"] = self::menu($datos["categoria"]->padres());
        //dd($datos["menu"]);
        
        
        $datos["productos"] = ProductoVentor::where("familia_id",$datos["categoria"]->familia["id"])->paginate($this->paginate)->onEachSide(5);
        
        return view('page.distribuidor',compact('title','view','datos'));
    }

    public function pedidoCategoria(Request $request, $familia_id, $id) {
        if(!auth()->guard('client')->check()) return redirect()->route('index');
        $title = "PEDIDO";
        $view = "page.parts.pedido";
        $dataRequest = $request->all();
        //$ids = $datos["categoria"]->familia->categoria->padres();
        $ids = [];
        $ids[] = $familia_id;
        $ids[] = $id;
        //dd($ids);
        $datos["empresa"] = self::general();
        $datos["menu"] = self::menu($ids);
        $buscar = $para = null;
        if(auth()->guard('client')->user()["is_vendedor"] == 1) {
            $natmer = Auth::user()["username"];
            $natmer = str_replace("VND_","",$natmer);
            $vendedor = Vendedor::where("natmer",$natmer)->first();
            $usuarios = Usuario::where("vendedor_id",$vendedor["id"])->where("username","!=","111")->where("is_vendedor",0)->get();
            $clientes = Cliente::where("vendedor_id",$vendedor["id"])->where("nrodoc","!=","111")->get();
            foreach($clientes AS $c)
                $c["nombreX"] = "{$c["nrocta"]} {$c["nombre"]}";
            $datos["clientes"] = $clientes->pluck("nombreX","id");
        } else if(auth()->guard('client')->user()["is_vendedor"] == 2) {
            $clientes = Cliente::where("nrodoc","!=","111")->get();
            foreach($clientes AS $c)
                $c["nombreX"] = "[{$c["nrocta"]}] {$c["nombre"]}";
            $datos["clientes"] = $clientes->pluck("nombreX","id");
        }
        if(!empty($dataRequest["buscar"]) && empty($dataRequest["para"])) {
            $buscar = $dataRequest["buscar"];
            $datos["productos"] = ProductoVentor::where("stmpdh_art","LIKE","%{$buscar}%")->orWhere("stmpdh_tex","LIKE","%{$buscar}%")->orderBy("stmpdh_art")->paginate($this->paginate)->onEachSide(5);
        } else if(empty($dataRequest["buscar"]) && !empty($dataRequest["para"])) {
            $para = $dataRequest["para"];
            $datos["productos"] = ProductoVentor::where("parte_id",$dataRequest["para"])->orderBy("stmpdh_art")->paginate($this->paginate)->onEachSide(5);
        } else if(!empty($dataRequest["buscar"]) && !empty($dataRequest["para"])) {
            $buscar = $dataRequest["buscar"];
            $para = $dataRequest["para"];
            $datos["productos"] = ProductoVentor::where("stmpdh_art","LIKE","%{$buscar}%")->where("parte_id",$dataRequest["para"])->orWhere("stmpdh_tex","LIKE","%{$buscar}%")->where("parte_id",$dataRequest["para"])->orderBy("stmpdh_art")->paginate($this->paginate)->onEachSide(5);
        } else
            $datos["productos"] = ProductoVentor::orderBy("stmpdh_art")->paginate($this->paginate)->onEachSide(5);
        $datos["para"] = ProductoVentor::orderBy("marca")->pluck("marca","marca_id");
        $datos["buscar"] = $buscar;
        $datos["paraID"] = $para;
        return view('page.distribuidor',compact('title','view','datos'));
    }

    public function pedidoCliente(Request $request) {
        if(!auth()->guard('client')->check()) return redirect()->route('index');
        $data = $request->all();
        
        $data["pedido"] = json_decode($data["pedido"], true);
        
        $Arr_data = [];
        $Arr_data["is_adm"] = 2;
        $Arr_data["usuario_id"] = NULL;
        $usuario = Usuario::find($data["idUsuario"]);
        if(isset($data["idCliente"])) {
            $cliente = Cliente::find($data["idCliente"]);
            $Arr_data["usuario_id"] = $data["idUsuario"];
            $Arr_data["vendedor_id"] = $data["idVendedor"];
        } else
            $cliente = Cliente::where("nrodoc",$usuario["username"])->first();
        $cliente->fill(["transporte_id" => $data["transporteID"]]);
        $cliente->save();
        
        $Arr_data["transporte_id"] = $data["transporteID"];
        $Arr_data["cliente_id"] = $cliente["id"];
        $Arr_data["estado"] = 1;
        $Arr_data["observaciones"] = $data["observaciones"];
        $pedido = Pedido::create($Arr_data);
        ($pedido);
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
        Cookie::queue("pedido", $pedido_id, 100);
        echo $pedido_id;
    }
    
    public function carrito() {
        if(!auth()->guard('client')->check()) return redirect()->route('index');
        //if(auth()->guard('client')->user()["username"] == "111") return redirect()->route('pedido');
        $title = "CARRITO";
        $view = "page.parts.pedido";
        $datos = [];
        
        $datos["menu"] = self::menu([]);
        $datos["empresa"] = self::general();
        $datos["transportes"] = Transporte::orderBy("descrp")->get()->pluck("descrp","id");
        $datos["cliente"] = Cliente::where("nrodoc",auth()->guard('client')->user()["username"])->first();
        $datos["carrito"] = 1;
        $datos["productos"] = [];
        return view('page.distribuidor',compact('title','view','datos'));
    }
}
