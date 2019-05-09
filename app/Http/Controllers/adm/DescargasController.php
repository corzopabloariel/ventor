<?php

namespace App\Http\Controllers\adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Descarga;
class DescargasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Descargas";
        $view = "adm.parts.descargas.index";
        $descargas = Descarga::orderBy('orden')->get();
        return view('adm.distribuidor',compact('title','view','descargas'));
    }

    public function cleanURL($string)
    {
        $url = str_replace("'", '', $string);
        $url = str_replace('%20', ' ', $url);
        $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
        $url = trim($url, "-");
        $url = iconv("utf-8", "us-ascii//TRANSLIT", $url); 
        $url = strtolower($url);
        $url = preg_replace('~[^-a-z0-9_]+~', '', $url);
        return $url;
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
        $ARR_data["image"] = null;
        $ARR_data["documento"] = null;
        $ARR_data["orden"] = $datosRequest["orden"];
        $ARR_data["nombre"] = $datosRequest["nombre"];

        $nameDOC = self::cleanURL($datosRequest["nombre"]);
        
        $file = $request->file("image");
        $documento = $request->file("documento");
        
        if(!is_null($data)) {
            $ARR_data["image"] = $data["image"];
            $ARR_data["documento"] = $data["documento"];
        }
        if(!is_null($file)) {
            $path = public_path('images/descargas/');
            if (!file_exists($path))
                mkdir($path, 0777, true);
            $imageName = time().".".$file->getClientOriginalExtension();
            
            $file->move($path, $imageName);
            $ARR_data["image"] = "images/descargas/{$imageName}";
            
            if(!is_null($data)) {
                if(!empty($data["image"])) {
                    $filename = public_path() . "/" . $data["image"];
                    if (file_exists($filename))
                        unlink($filename);
                }
            }
        }
        if(!is_null($documento)) {
            $path = public_path('images/descargas/');
            if (!file_exists($path))
                mkdir($path, 0777, true);
            $imageName = "{$nameDOC}.".$documento->getClientOriginalExtension();
            
            $documento->move($path, $imageName);
            $ARR_data["documento"] = "images/descargas/{$imageName}";
            
            if(!is_null($data)) {
                if(!empty($data["documento"])) {
                    $filename = public_path() . "/" . $data["documento"];
                    if (file_exists($filename))
                        unlink($filename);
                }
            }
        }
        
        if(is_null($data))
            Descarga::create($ARR_data);
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
        return Descarga::find($id);
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
        $filename = public_path() . "/{$data["image"]}";
        if (file_exists($filename))
            unlink($filename);
        $filename = public_path() . "/{$data["documento"]}";
        if (file_exists($filename))
            unlink($filename);

        Descarga::destroy($id);
        return 1;
    }
}
