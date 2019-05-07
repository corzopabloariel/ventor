<?php

namespace App\Http\Controllers\adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Recurso;
class RecursosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Recursos humanos";
        $view = "adm.parts.recurso.index";
        $recursos = Recurso::orderBy('orden')->get();

        return view('adm.distribuidor',compact('title','view','recursos'));
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
        
        $ARR_data["titulo"] = $datosRequest["titulo_es"];
        $ARR_data["orden"] = $datosRequest["orden"];
        $ARR_data["zona"] = $datosRequest["zona_es"];
        $ARR_data["descripcion"] = $datosRequest["descripcion_es"];
        $ARR_data["in_zone"] = empty($datosRequest["in_zone"]) ? 0 : $datosRequest["in_zone"];
        
        if(is_null($data))
            Recurso::create($ARR_data);
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
        return Recurso::find($id);
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
        Recurso::destroy($id);
        return 1;
    }
}
