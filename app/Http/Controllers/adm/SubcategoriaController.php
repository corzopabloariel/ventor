<?php

namespace App\Http\Controllers\adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Categoria;

class SubcategoriaController extends Controller
{
    public function rec_hijos($data) {
        $data["hijos"] = $data->hijos;
        
        if(empty($data["hijos"]))
            return $data;
        else {
            foreach($data["hijos"] AS $h)
                $h["hijos"] = self::rec_hijos($h);
            return $data["hijos"];
        }
    }
    public function select2($data) {
        if(count($data["hijos"]) == 0) {
            return ["id" => $data["id"], "text" => $data["nombre"]];
        } else {
            $aux = [];
            for($i = 0; $i < count($data["hijos"]); $i++) {
                $aux[] = self::select2($data["hijos"][$i]);
            }
            return $aux;
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $ARR_data["nombre"] = $datosRequest["nombre_sub"];
        $ARR_data["orden"] = $datosRequest["orden_sub"];
        $ARR_data["tipo"] = $datosRequest["tipo"];
        $ARR_data["padre_id"] = empty($datosRequest["padre_id"]) ? null : $datosRequest["padre_id"];

        $file = $request->file("image_sub");
        
        if(!is_null($data))
            $ARR_data["image"] = $data["image"];
        if(!is_null($file)) {
            $path = public_path('images/subcategorias/');
            if (!file_exists($path))
                mkdir($path, 0777, true);
            $imageName = time() . "-{$datosRequest["tipo"]}.".$file->getClientOriginalExtension();
            
            $file->move($path, $imageName);
            $ARR_data["image"] = "images/subcategorias/{$imageName}";
            
            if(!is_null($data)) {
                if(!empty($data["image"])) {
                    $filename = public_path() . "/" . $data["image"];
                    if (file_exists($filename))
                        unlink($filename);
                }
            }
        }
        
        if(is_null($data)) {
            $data = Categoria::create($ARR_data);
            $data["subcategorias"] = 0;
            return $data;
        } else {
            $data->fill($ARR_data);
            $data->save();

            return self::edit($data["id"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        if(empty($id)) return [];
        $data = self::edit($id);

        $select2 = [];
        $data["hijos"] = self::rec_hijos($data);
        $select2[] = ["id" => "", "text" => ""];
        foreach($data["hijos"] AS $h) {
            if(count($h->hijos) == 0)
                $select2[] = ["id" => $h["id"], "text" => $h["nombre"]];
            else
                $select2[] = ["text" => $h["nombre"], "children" => self::select2($h)];
        }
        //dd($select2);
        return $select2;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Categoria::find($id);
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
        //
    }
}
