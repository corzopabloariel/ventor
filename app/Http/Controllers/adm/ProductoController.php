<?php

namespace App\Http\Controllers\adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Origen;
use App\Categoria;
use App\Marca;
use App\Producto;
class ProductoController extends Controller
{
    public function rec_categorias( $data ) {
        if(empty($data->hijos))
            return $data["nombre"];
        else {
            foreach($data->hijos AS $h)
                return "{$data["nombre"]}, " . self::rec_categorias($h);
        }
    }
    public function rec_hijos($data) {
        if(isset($data->hijos))
            $data["hijos"] = $data->hijos;
        else
            $data["hijos"] = $data->modelos;
        
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Productos";
        $view = "adm.parts.productos.index";
        $origenes = Origen::orderBy('nombre')->get();
        $categorias = Categoria::whereNotNull("padre_id")->orderBy("tipo")->orderBy("orden")->get();
        $familias = Categoria::whereNull("padre_id")->orderBy('orden')->get();
        $modelos = Marca::whereNull("padre_id")->orderBy('nombre')->get();
        $productos = Producto::orderBy("orden")->get();
        $select2 = [];
        $select2["origenes"] = [];
        $select2["familias"] = [];
        $select2["modelos"] = [];

        foreach($modelos AS $h) {
            $h["hijos"] = self::rec_hijos($h);
            if(count($h->modelos) == 0)
                $select2["modelos"][] = ["id" => $h["id"], "text" => $h["nombre"]];
            else
                $select2["modelos"][] = ["text" => $h["nombre"], "children" => self::select2($h)];
        }
        foreach($origenes AS $e)
            $select2["origenes"][] = ["id" => $e["id"],"text" => $e["nombre"],"img" => $e["image"]];
        foreach($familias AS $e)
            $select2["familias"][] = ["id" => $e["id"],"text" => $e["nombre"],"img" => $e["image"], "style" => "width: 60px; filter: {$e["hsl"]}"];
        foreach($productos AS $p) {
            $p["nombre"] = $p->getNombreCodigoAttribute();
            $p["precio"] = "$ " . $p->getPrecio();
            $p["marcaTexto"] = $p->marca->getNombreEnteroAttribute();
            $p["categoriaTexto"] = $p->categoria->getCategoriaEnteroAttribute();
            
        }
        return view('adm.distribuidor',compact('title','view','productos','select2'));
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
        $flagReturn = false;
        if(!isset($datosRequest["categoria_id"]))
            $flagReturn = true;

        if($flagReturn)
            return back()->withErrors(['mssg' => "Categoría, origen, modelo, nombre y código son necesarios"])->withInput($datosRequest);
        
        $ARR_data = [];
        $ARR_data["catalogo"] = null;
        $ARR_data["image"] = null;
        $ARR_data["codigo"] = $datosRequest["codigo"];
        $ARR_data["nombre"] = $datosRequest["nombre"];
        $ARR_data["orden"] = $datosRequest["orden"];
        
        $ARR_data["mercadolibre"] = $datosRequest["mercadolibre"];
        $ARR_data["cantidad"] = $datosRequest["cantidad"];
        $ARR_data["link"] = self::cleanURL(strip_tags($datosRequest["nombre"]));
        
        $ARR_data["familia_id"] = $datosRequest["familia_id"];
        $ARR_data["categoria_id"] = $datosRequest["categoria_id"];
        $ARR_data["origen_id"] = $datosRequest["origen_id"];
        $ARR_data["marca_id"] = $datosRequest["marca_id"];
        //dd($datosRequest);
        $precio = 0;
        if(isset($datosRequest["precio"])) {
            $precio = $datosRequest["precio"];
            $precio = str_replace("$","",$precio);
            $precio = str_replace(".","",$precio);
            $precio = str_replace(",",".",$precio);
            $precio = trim($precio);
        }
        $ARR_data["precio"] = $precio;
        
        $file = $request->file("image");
        $catalogo = $request->file("catalogo");
        if(!is_null($data)) {
            $ARR_data["image"] = $data["image"];
            $ARR_data["catalogo"] = $data["catalogo"];
        }
        if(!is_null($file)) {
            $path = public_path('images/productos/');
            if (!file_exists($path))
                mkdir($path, 0777, true);
            $imageName = "{$ARR_data["link"]}.".$file->getClientOriginalExtension();
            
            $file->move($path, $imageName);
            $ARR_data["image"] = "images/productos/{$imageName}";
            
            if(!is_null($data)) {
                if(!empty($data["image"])) {
                    $filename = public_path() . "/" . $data["image"];
                    if (file_exists($filename))
                        unlink($filename);
                }
            }
        }
        if(!is_null($catalogo)) {
            $path = public_path('images/catalogos/');
            if (!file_exists($path))
                mkdir($path, 0777, true);
            $imageName = "{$ARR_data["link"]}.".$file->getClientOriginalExtension();
            
            $file->move($path, $imageName);
            $ARR_data["catalogo"] = "images/catalogos/{$imageName}";
            
            if(!is_null($data)) {
                if(!empty($data["catalogo"])) {
                    $filename = public_path() . "/" . $data["catalogo"];
                    if (file_exists($filename))
                        unlink($filename);
                }
            }
        }
        
        if(is_null($data))
            Producto::create($ARR_data);
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
        $data = Producto::find($id);
        $data["precio"] = $data->getPrecio();
        return $data;
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
        return self::store($request, self::edit($id));
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
