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
        $novedades = Novedad::orderBy('orden')->get();
        return view('adm.distribuidor',compact('title','view','novedades'));
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
        $ARR_data["documento"] = null;
        $ARR_data["nombre"] = $datosRequest["nombre"];
        $ARR_data["orden"] = $datosRequest["orden"];
        $ARR_data["url"] = $datosRequest["url"];

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
            $imageName = time() . "." .$image->getClientOriginalExtension();
            
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
            $path = public_path('images/novedades/');
            if (!file_exists($path))
                mkdir($path, 0777, true);
            $imageName = time() . "-doc." .$documento->getClientOriginalExtension();
            
            $documento->move($path, $imageName);
            $ARR_data["documento"] = "images/novedades/{$imageName}";
            
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
