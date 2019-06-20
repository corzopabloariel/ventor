<?php

namespace App\Http\Controllers\adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Categoria;
use App\FamiliaVentor;
use App\PartesVentor;

class CategoriaController extends Controller
{
    public $idioma = "es";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Categoría";
        $view = "adm.parts.categoria.index";
        $categorias = Categoria::whereNull("padre_id")->orderBy('orden')->paginate(15);
        $familiasV = FamiliaVentor::orderBy("usr_stmati")->get()->pluck("usr_stmati","id");
        foreach($categorias AS $c) {
            $familia_id = $c->familia;
            $c["familia_id"] = $familia_id["usr_stmati"];
            $c["partes"] = $c->partes;
        }
        
        return view('adm.distribuidor',compact('title','view','categorias','seccion','familiasV','partesV'));
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
        $ARR_data["nombre"] = $datosRequest["nombre"];
        $ARR_data["orden"] = $datosRequest["orden"];
        $ARR_data["color"] = $datosRequest["color"];
        $ARR_data["hsl"] = $datosRequest["hsl"];
        $ARR_data["padre_id"] = empty($datosRequest["padre_id"]) ? null : $datosRequest["padre_id"];
        //$ARR_data["familia_id"] = empty($datosRequest["familia_id"]) ? null : $datosRequest["familia_id"];

        $file = $request->file("image");
        
        if(!is_null($data))
            $ARR_data["image"] = $data["image"];
        if(!is_null($file)) {
            $path = public_path('images/categorias/');
            if (!file_exists($path))
                mkdir($path, 0777, true);
            $imageName = time() . "." .$file->getClientOriginalExtension();
            
            $file->move($path, $imageName);
            $ARR_data["image"] = "images/categorias/{$imageName}";
            
            if(!is_null($data)) {
                if(!empty($data["image"])) {
                    $filename = public_path() . "/" . $data["image"];
                    if (file_exists($filename))
                        unlink($filename);
                }
            }
        }
        //dd($request->get('familia_id'));
        if(is_null($data)) {
            $data = Categoria::create($ARR_data);
            $data->partes()->sync($request->get('familia_id'));
        } else {
            unset($data["partes"]);
            $data->fill($ARR_data);
            $data->partes()->sync($request->get('familia_id'));
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
    public function show($id,$tipo)
    {
        $data = self::edit($id);
        $data["hijos"] = $data->hijos;
        $data["padre"] = $data->padre;

        $familia = $data->familia;
        
        $data["partes"] = $data->partes;

        foreach($data["hijos"] AS $h) {
            $cat = $h->categoria;
            $h["categoria_id"] = $cat["descrp"];
            $h["subcategorias"] = count($h->hijos);
        }
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
        $c = Categoria::find($id);
        $c["partes"] = $c->partes;
        return $c;
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
