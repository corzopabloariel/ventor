<?php

namespace App\Http\Controllers\adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Marca;
class MarcasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Marcas";
        $view = "adm.parts.marcas.index";
        $marcas = Marca::whereNull("padre_id")->orderBy('nombre')->get();

        foreach($marcas AS $c)
            $c["mod"] = count($c->modelos);
        
        return view('adm.distribuidor',compact('title','view','marcas','seccion'));
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
        
        $ARR_data["image"] = null;
        $ARR_data["nombre"] = isset($datosRequest["nombre"]) ? $datosRequest["nombre"] : $datosRequest["nombre_sub"];
        $ARR_data["padre_id"] = empty($datosRequest["padre_id"]) ? null : $datosRequest["padre_id"];

        $file = $request->file("image");
        
        if(!is_null($data))
            $ARR_data["image"] = $data["image"];
        if(!is_null($file)) {
            $path = public_path('images/marcas/');
            if (!file_exists($path))
                mkdir($path, 0777, true);
            $imageName = time() . "." .$file->getClientOriginalExtension();
            
            $file->move($path, $imageName);
            $ARR_data["image"] = "images/marcas/{$imageName}";
            
            if(!is_null($data)) {
                if(!empty($data["image"])) {
                    $filename = public_path() . "/" . $data["image"];
                    if (file_exists($filename))
                        unlink($filename);
                }
            }
        }
        
        if(isset($datosRequest["nombre"])) {
            if(is_null($data))
                Marca::create($ARR_data);
            else {
                $data->fill($ARR_data);
                $data->save();
            }
            return back();
        } else {
            if(is_null($data))
                $data = Marca::create($ARR_data);
            else {
                $data->fill($ARR_data);
                $data->save();

                $data = self::edit($data["id"]);
            }
            return $data;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = self::edit($id);
        $data["hijos"] = $data->modelos;

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
        return Marca::find($id);
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
        $data = self::show($id);

        if(!empty($data["hijos"])) {
            //TIENE IMAGEN
            if(!is_null($data["image"])) {
                $filename = public_path() . "/{$data["image"]}";
                if (file_exists($filename))
                    unlink($filename);
            }
        }

        Marca::destroy($id);
        return 1;
    }
}
