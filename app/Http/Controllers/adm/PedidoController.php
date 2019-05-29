<?php

namespace App\Http\Controllers\adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Usuario;
use App\User;
use App\Vendedor;
use App\Cliente;
use App\Pedido;
use App\PedidoProducto;
use App\Transporte;
use App\ProductoVentor;
use Cookie;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Pedidos";
        $view = "adm.parts.pedido";
        $transporte = Transporte::get()->pluck("descrp","id");
        if(Auth::user()["is_admin"] == 2) {
            $natmer = Auth::user()["username"];
            $natmer = str_replace("VND_","",$natmer);
            $vendedor = Vendedor::where("natmer",$natmer)->first();
            $usuarios = Usuario::where("vendedor_id",$vendedor["id"])->paginate(15);
            $clientesUsuarios = Usuario::where("vendedor_id",$vendedor["id"])->get()->pluck("name","nrodoc");
            $pedidos = Pedido::where("vendedor_id",$vendedor["id"])->where("is_adm",0)->orderBy("id","DESC")->paginate(15);
        } else {
            $pedidos = Pedido::orderBy("id","DESC")->paginate(15);
            $usuarios = Usuario::orderBy('username')->paginate(15);
            $clientesUsuarios = Cliente::orderBy('nrodoc')->get()->pluck("nombre","nrodoc");
        }

        foreach($usuarios AS $u) {
            $u["nombre"] = $u->nombre();
            $u["descuento"] = $u->descuento();
        }

        foreach($pedidos AS $p) {
            $c = $p->cliente;
            $t = $p->transporte;
            
            $p["cliente_id"] = $c["nombre"];
            $p["transporte_id"] = $t["descrp"];
        }
        
        return view('adm.distribuidor',compact('title','view','usuarios','pedidos','clientesUsuarios','transporte'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title = "Pedido nuevo";
        $buscar = null;
        $view = "adm.parts.pedido.create";
        if(!empty($request->all()["buscar"])) {
            $buscar = $request->all()["buscar"];
            Cookie::queue("buscar", $buscar, 100);
            $productos = ProductoVentor::where("stmpdh_art","LIKE","%{$buscar}%")->orWhere("stmpdh_tex","LIKE","%{$buscar}%")->orderBy("stmpdh_art")->paginate(15);
        } else
            $productos = ProductoVentor::orderBy("stmpdh_art")->paginate(8);
        foreach($productos AS $p) {
            $p["modelo_id"] = $p->modelo_id();
            $p["familia_id"] = $p->familia_id();
            
            $p["parte_id"] = $p->parte_id();
            $p["precio"] = "$ " . $p->getPrecio();
            //$p["marcaTexto"] = $p->marca->getNombreEnteroAttribute();
            //$p["categoriaTexto"] = $p->categoria->getCategoriaEnteroAttribute();
        }

        return view('adm.distribuidor',compact('title','view','productos','buscar'));
    }

    public function confirmar() {
        $title = "Pedido nuevo";
        $buscar = null;
        $view = "adm.parts.pedido.confirmar";

        $transporte = Transporte::get()->pluck("descrp","id");
        if(Auth::user()["is_admin"] == 2) {
            $natmer = Auth::user()["username"];
            $natmer = str_replace("VND_","",$natmer);
            $vendedor = Vendedor::where("natmer",$natmer)->first();
            $usuarios = Usuario::where("vendedor_id",$vendedor["id"])->paginate(15);
            $pedidos = Pedido::where("vendedor_id",$vendedor["id"])->orderBy("id","DESC")->paginate(15);
            
            $clientesUsuarios = Cliente::where("vendedor_id",$vendedor["id"])->orderBy('nrodoc')->get();
            
        } else {
            $pedidos = Pedido::orderBy("id","DESC")->paginate(15);
            $usuarios = Usuario::orderBy('username')->paginate(15);
            $clientesUsuarios = Cliente::orderBy('nrodoc')->get();
        }

        $Arr = [];
        foreach($clientesUsuarios AS $c) 
            $Arr[$c["id"]] = "{$c["nrocta"]} {$c["nombre"]}";
        $clientesUsuarios = $Arr;
        return view('adm.distribuidor',compact('title','view','buscar','clientesUsuarios','transporte'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $data = $request->all();
        $data["pedido"] = json_decode($data["pedido"], true);
        $Arr_data = [];
        $Arr_data["cliente_id"] = isset($data["cliente_id"]) ? $data["cliente_id"] : null;
        $Arr_data["observaciones"] = $data["observaciones"];
        if(isset($data["idPedido"])) {
            Pedido::destroy($data["idPedido"]);
            $Arr_data["cliente_id"] = $data["idCliente"];
        }
        $Arr_data["is_adm"] = 1;
        if(Auth::user()["is_admin"] == 2) {
            $Arr_data["is_adm"] = 0;
            $natmer = Auth::user()["username"];
            $natmer = str_replace("VND_","",$natmer);
            $vendedor = Vendedor::where("natmer",$natmer)->first();
            $Arr_data["vendedor_id"] = $vendedor["id"];
        }
        $Arr_data["usuario_id"] = Auth::user()["id"];

        $Arr_data["cliente_id"] = $data["cliente_id"];
        $Arr_data["transporte_id"] = $data["transporte_id"];
        //dd($Arr_data);
        $pedido = Pedido::create($Arr_data);
        $pedido_id = $pedido["id"];
        //dd($pedido_id);
        foreach($data["pedido"] AS $id => $val) {
            if($id == "TOTAL") continue;
            $Arr_p = [];
            $Arr_p["pedido_id"] = $pedido_id;
            $Arr_p["producto_id"] = $id;
            $Arr_p["cnt"] = $val["PEDIDO"];
            $Arr_p["observ"] = "0";
            
            PedidoProducto::create($Arr_p);
        }
        
        Cookie::queue("pedido", $pedido_id, 100);
        return 1;
        //return redirect('adm/export');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Pedido::find($id);
        $data["productos"] = $data->hijos;

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
