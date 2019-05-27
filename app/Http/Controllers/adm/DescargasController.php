<?php

namespace App\Http\Controllers\adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
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
        $title = "Descargas públicas";
        $view = "adm.parts.descargas.index";
        $descargas = Descarga::where("privado",0)->orderBy('orden')->get();
        return view('adm.distribuidor',compact('title','view','descargas'));
    }
    public function private()
    {
        $title = "Descargas privadas";
        $view = "adm.parts.descargas.private";
        /*$descargasPrecio = DB::table('descargas')
                            ->where("privado",1)
                            ->where("precio",1)
                            ->groupBy('did')
                            ->get();*/
        $descargasPrecio = Descarga::where("privado",1)->groupBy("did")->get();
        return view('adm.distribuidor',compact('title','view','descargasPrecio'));
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
    public function storeEXT(Request $request, $data = null) {
        $datosRequest = $request->all();
        
        $aux = Descarga::where("did","!=",0)->orderBy("id","DESC")->first();
        
        $ARR_data = [];
        $ARR_data["image"] = null;
        if(empty($data))
            $ARR_data["did"] = empty($aux) ? 1 : $aux["did"] + 1;
        else {
            $ARR_data["did"] = $data[0]["did"];
            $ARR_data["image"] = $data[0]["image"];

            for( $i = 0; $i < count($data) ; $i++)
                $data[$i]["sigue"] = 1;
        }
        $ARR_data["orden"] = $datosRequest["orden"];
        $ARR_data["nombre"] = $datosRequest["nombre"];
        $ARR_data["privado"] = 1;
        $ARR_data["precio"] = 1;
        
        $file = $request->file("image");
        
        $documento_ext = $request->file("documento_ext");
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
        for($i = 0; $i < count($datosRequest["ext_formato"]); $i ++) {
            $obj = null;
            $ARR_data["documento"] = null;
            if(!empty($data)) {
                for( $j = 0; $j < count($data) ; $j++) {
                    if($data[$j]["id"] == $datosRequest["idEXT"][$i]) {
                        $obj = $data[$j];
                        unset($obj["sigue"]);
                        $ARR_data["documento"] = $obj["documento"];

                        break;
                    }
                }
            }
            $ARR_data["formato"] = strtoupper($datosRequest["ext_formato"][$i]);
            if(!is_null($documento_ext[$i])) {
                $path = public_path('images/descargas/');
                if (!file_exists($path))
                    mkdir($path, 0777, true);
                $imageName = time() . "-{($i + 1)}." . $documento_ext[$i]->getClientOriginalExtension();
                
                $documento_ext[$i]->move($path, $imageName);
                $ARR_data["documento"] = "images/descargas/{$imageName}";
                
                if(!is_null($data)) {
                    if(!empty($obj["documento"])) {
                        $filename = public_path() . "/" . $obj["documento"];
                        if (file_exists($filename))
                            unlink($filename);
                    }
                }
            }
            if(is_null($data))
                Descarga::create($ARR_data);
            else {
                $obj->fill($ARR_data);
                $obj->save();
            }
        }
        if(!empty($data)) {
            for( $i = 0; $i < count($data) ; $i++) {
                if(isset($data[$i]["sigue"])) {
                    Descarga::destroy($data[$i]["id"]);
                    if(!empty($data[$i]["documento"])) {
                        $filename = public_path() . "/{$data[$i]["documento"]}";
                        if (file_exists($filename))
                            unlink($filename);
                    }
                }
            }
        }
        return back();
    }
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
        $aux = Descarga::find($id);
        return Descarga::where("did",$aux["did"])->get();
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

    public function updateEXT(Request $request, $id) {
        return self::storeEXT($request,self::show($id));
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

    public function deleteEXT($id) {
        $datas = self::show($id);
        foreach($datas AS $data) {
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
            Descarga::destroy($data["id"]);
        }
        return 1;
    }
}
