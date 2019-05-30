<?php

namespace App\Http\Controllers\adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Numero;
class NumerosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Empresa :: Números";
        $view = "adm.parts.empresa.numeros";
        $seccion = "empresa";
        $numeros = Numero::orderBy("orden")->get();
        return view('adm.distribuidor',compact('title','view','seccion','numeros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $data = null)
    {
        $datosRequest = $request->all();
        
        $ARR_data = [];
        $ARR_data["orden"] = $datosRequest["orden"];
        $ARR_data["provincia"] = $datosRequest["provincia"];
        $ARR_data["nombre"] = $datosRequest["nombre"];
        $ARR_data["persona"] = $datosRequest["persona"];
        $ARR_data["interno"] = $datosRequest["interno"];
        $ARR_data["email"] = json_encode($datosRequest["email_email"]);

        if(empty($data))
            Numero::create($ARR_data);
        else {
            $data->fill($ARR_data);
            $data->save();
        }
        return back();
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
        return Numero::find($id);
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
        return self::store($request,self::edit($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Numero::destroy($id);
        return 1;
    }
}
