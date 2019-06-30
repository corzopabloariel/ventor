<?php

namespace App\Http\Controllers\adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Cliente;
use App\Usuario;
use App\User;
use App\Vendedor;
use App\Pedido;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Clientes";
        $view = "adm.parts.clientes";
        ///if(Auth::user()["is_admin"] == 2) {
            //$natmer = Auth::user()["username"];
            //$natmer = str_replace("VND_","",$natmer);
            //$vendedor = Vendedor::where("natmer",$natmer)->first();
            //$usuarios = Usuario::where("vendedor_id",$vendedor["id"])->where("is_vendedor",0)->paginate(15);
        //} else
            $usuarios = Usuario::orderBy('username')->paginate(15);

        foreach($usuarios AS $u) {
            $u["nombre"] = $u->nombre();
            $u["descuento"] = $u->descuento();
        }
        //dd($usuarios);
        
        return view('adm.distribuidor',compact('title','view','usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function transporte($id) {
        $data = Cliente::find($id);
        return empty($data["transporte_id"]) ? "" : $data["transporte_id"];
    }
    public function porcentaje(Request $request, $id)
    {
        $dataRequest = $request->all();
        $u = Usuario::find($id);

        $u->fill(["descuento" => $dataRequest["descuento"] / 100]);
        $u->save();
        return $dataRequest["descuento"];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
