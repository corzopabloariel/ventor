<?php

namespace App\Http\Controllers\adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Novedad;
class NovedadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Novedades";
        $view = "adm.parts.novedades.index";
        $novedades = [];
        $novedades = Novedad::orderBy('orden')->get();
        return view('adm.distribuidor',compact('title','view','novedades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function orden(Request $request, $data = null)
    {
        $datosRequest = $request->all();
        $ids = $datosRequest["ids"];
        $ids = json_decode($ids, true);
        for($i = 0; $i < count($ids); $i++) {
            $aux = Novedad::find($ids[$i]);
            $aux->fill(["orden" => $i]);
            $aux->save();
        }
        return 1;
    }
    public function store(Request $request, $data = null)
    {
        $datosRequest = $request->all();

        $ARR_data["image"] = null;
        $ARR_data["documento"] = null;
        $ARR_data["nombre"] = isset($datosRequest["nombre"]) ? $datosRequest["nombre"] : null;
        //$ARR_data["orden"] = isset($datosRequest["orden"]) ? $datosRequest["orden"] : null;
        $ARR_data["url"] = isset($datosRequest["url"]) ? $datosRequest["url"] : null;

        $image = $request->file("image");
        $documento = $request->file("documento");

        if(!is_null($data)) {
            $ARR_data["image"] = $data["image"];
            $ARR_data["documento"] = $data["documento"];
        }
        if(!is_null($image)) {
            $path = public_path('images/novedades/');
            if (!file_exists($path))
                mkdir($path, 0777, true);
            $imageName = $image->getClientOriginalName() . "." .$image->getClientOriginalExtension();

            $image->move($path, $imageName);
            $ARR_data["image"] = "images/novedades/{$imageName}";

            if(!is_null($data)) {
                if(!empty($data["image"])) {
                    $filename = public_path() . "/" . $data["image"];
                    if (file_exists($filename))
                        unlink($filename);
                }
            }
        }
        if(!is_null($documento)) {
            $path = public_path('archivos/novedades/');
            if (!file_exists($path))
                mkdir($path, 0777, true);
            $imageName = $documento->getClientOriginalName() . "." .$documento->getClientOriginalExtension();

            $documento->move($path, $imageName);
            $ARR_data["documento"] = "archivos/novedades/{$imageName}";

            if(!is_null($data)) {
                if(!empty($data["documento"])) {
                    $filename = public_path() . "/" . $data["documento"];
                    if (file_exists($filename))
                        unlink($filename);
                }
            }
        }

        if(is_null($data))
            Novedad::create($ARR_data);
        else {
            $data->fill($ARR_data);
            $data->save();
        }
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Novedad::find($id);
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
        $data = self::edit($id);

        if(!empty($data["image"])) {
            $filename = public_path() . "/{$data["image"]}";
            if (file_exists($filename))
                unlink($filename);
        }
        if(!empty($data["documento"])) {
            $filename = public_path() . "/{$data["documento"]}";
            if (file_exists($filename))
                unlink($filename);
        }

        Novedad::destroy($id);
        return 1;
    }
}
