<?php

namespace App\Http\Controllers\adm;
use org\majkel\dbase\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Origen;
use App\Categoria;
use App\Marca;
use App\Producto;
use App\ProductoVentor;

use App\Archivo;
use App\User;
use App\Vendedor;
use App\Localidad;
use App\Transporte;
use App\Usuario;
use App\Cliente;
use App\MarcaVentor;
use App\ModeloVentor;
use App\PartesVentor;
use App\FamiliaVentor;

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
    public function index(Request $request)
    {
        $title = "Productos";
        $buscar = null;
        $view = "adm.parts.productos.index";
        $origenes = Origen::orderBy('nombre')->get();
        $categorias = Categoria::whereNotNull("padre_id")->orderBy("tipo")->orderBy("orden")->get();
        $familias = Categoria::whereNull("padre_id")->orderBy('orden')->get();
        $modelos = Marca::whereNull("padre_id")->orderBy('nombre')->get();
        //$productos = Producto::orderBy("orden")->get();
        if(!empty($request->all()["buscar"])) {
            $buscar = $request->all()["buscar"];
            $productos2 = ProductoVentor::where("stmpdh_art","LIKE","%{$buscar}%")->orWhere("stmpdh_tex","LIKE","%{$buscar}%")->orderBy("stmpdh_art")->paginate(15);
        } else
            $productos2 = ProductoVentor::orderBy("stmpdh_art")->paginate(15);
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
        foreach($productos2 AS $p) {
            $p["modelo_id"] = $p->modelo_id();
            $p["familia_id"] = $p->familia_id();
            
            $p["parte_id"] = $p->parte_id();
            $p["precio"] = "$ " . $p->getPrecio();
            //$p["marcaTexto"] = $p->marca->getNombreEnteroAttribute();
            //$p["categoriaTexto"] = $p->categoria->getCategoriaEnteroAttribute();
        }
        return view('adm.distribuidor',compact('title','view','select2','productos2','buscar'));
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
        $ARR_data["novedad"] = $datosRequest["novedad"];
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
        $prod = ProductoVentor::find($id);

        $prod["modelo_id"] = $prod->modelo_id();
        $prod["familia_id"] = $prod->familia_id();
        
        $prod["parte_id"] = $prod->parte_id();
        $prod["precioSin"] = $prod["precio"];
        $prod["precio"] = "$ " . $prod->getPrecio();
        return $prod;
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

    public function carga(Request $request)
    {
        $cambios = "";
        if(isset($request["_token"])) {
            $data = $request->all();
            $files = $request->file("archivos");
            //dd($files);
            if(!empty($files)) {
                $path = public_path('file/');
                $archivos = "";
                $total = 0;
                foreach($files AS $i => $file) {
                    if(!empty($archivos)) $archivos .= " / ";
                    $actual = $file->getClientOriginalName();
                    if(strcmp($actual,$data["nombre"][$i]) === 0) {
                        $total ++;
                        $aux = explode(".",$data["nombre"][$i]);
                        
                        $doc = "{$aux[0]}." .$file->getClientOriginalExtension();
                        $archivos .= $doc;
                        $file->move($path, $doc);
                    }
                }
                Archivo::create(["archivos" => $archivos, "cantidad" => $total]);
            }
        }
        $data = Archivo::orderBy('id','DESC')->first();
        $cambios = "{$data["archivos"]}<br/>{$data["autofecha"]}";
        $title = "Carga de datos";
        $buscar = null;
        $view = "adm.parts.productos.carga";
        return view( 'adm.distribuidor' , compact( 'title' , 'view' , 'cambios' ) );
    }
    public function actualizar($id) {
        self::$id();
    }
    public function producto() {
        set_time_limit(0);
        $total = 0;
        $property = [
            'stmpdh_art',
            'use',
            'codigo_ima',
            'stmpdh_tex',
            'usr_stmpdh',
            'precio',
            'web_marcas',
            'parte',
            'parte_dbf_',
            'modelo_y_a',
            'usr_stmati',
            'grupo_web',
            'cantminvta',
            'fecha_ingr',
            'nro_refere'
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('productosventor')->truncate();

        
		//$fichero_dbf = asset('file/cnv_precios.DBF');
        //print_r($fichero_dbf);die();
        //$conex       = dbase_open($fichero_dbf, 0);
        //dd($conex);
        $dbf = Table::fromFile('file/cnv_precios.dbf');
        $asd = 0;
		foreach ($dbf as $record) {
            //dd($record);
            $codigo = $record->STMPDH_ART;
            //$nombre = $record->STMPDH_TEX;
            //$nombre = mb_convert_encoding($record->STMPDH_TEX);
            //$nombre = iconv("CP850","UTF-8", $record->STMPDH_TEX);
            //$nombre = iconv("IBM850", "UTF-8//TRANSLIT", $record->STMPDH_TEX);
            $nombre = iconv("850", "ISO-8859-1", $record->STMPDH_TEX);
            //$nombre = iconv("IBM850", "UTF-8", $record->STMPDH_TEX);
            //$nombre = mb_convert_encoding($record->STMPDH_TEX, "CP850", mb_detect_encoding($record->STMPDH_TEX, "UTF-8, CP850, ISO-8859-15", true));

            //print_r(mb_detect_encoding($nombre));
            //return 0;
            $data = ProductoVentor::where('stmpdh_art','LIKE',$codigo)->where('stmpdh_tex','LIKE',$nombre)->first();
            if( empty( $data ) ) {
                $total ++;
                $web_marcas = $modelo_y_a = $parte = $parte_dbf_ = $usr_stmati = $stmpdh_tex =null;
                for( $j = 0 ; $j < count( $property ) ; $j++ ) {
                    $key = strtoupper( $property[$j] );
                    $valor = $record->$key;
                    //$valor = iconv("IBM850", "UTF-8", $valor);
                    $valor = iconv("IBM850", "UTF-8//TRANSLIT", $valor);
                    //$valor = mb_convert_encoding ($valor, "ISO-8859-1");
                    if($property[$j] == "web_marcas" || $property[$j] == "parte" || $property[$j] == "parte_dbf_" || $property[$j] == "modelo_y_a" || $property[$j] == "usr_stmati" || $property[$j] == "stmpdh_tex") {
                        ${$property[$j]} = $valor;
                        //${$property[$j]} = iconv("IBM850", "UTF-8", $valor);
                        //${$property[$j]} = iconv("850", "ISO-8859-1", $valor);
                        //${$property[$j]} = iconv("IBM850", "UTF-8//TRANSLIT", $valor);
                        //${$property[$j]} = iconv("CP850","UTF-8", $valor);
                        //${$property[$j]} = mb_convert_encoding($valor, "CP850", mb_detect_encoding($valor, "UTF-8, CP850, ISO-8859-15", true));
                        continue;
                    }
                    if( strtolower( $property[$j] ) == "precio" || strtolower( $property[$j] ) == "cantminvta" || strtolower( $property[$j] ) == "usr_stmpdh" )
                        $valor = floatval( $valor );
                    if( strtolower( $property[$j] ) == "fecha_ingr" ) {
                        if ( strpos( $valor, ".m." ) == false )
                            $valor = null;
                        else {
                            list($fecha,$hora) = explode( " " , $valor );
                            list($d,$m,$a) = explode( "/" , $fecha );
                            $fecha = "{$a}/{$m}/{$d}";
                            if ( strpos( $hora , "p.m." ) == false )//AM
                                $hora = str_replace( " a.m." , "" , $hora );
                            else {
                                $hora = str_replace( " p.m." , "" , $hora );
                                list( $h , $m , $s ) = explode( ":" , $hora );
                                $h += 12;
                                $hora = "{$h}:{$m}:{$s}";
                            }
                            $valor = "{$fecha} {$hora}";
                        }
                    }
                    $echo[$property[$j]] = $valor;
                }
                $echo["stmpdh_tex"] = $stmpdh_tex;
                if(empty($modelo_y_a))
                    $modelo_y_a = "Sin especificar";
                $data_marca = MarcaVentor::where('web_marcas','LIKE',$web_marcas)->first();
                if(empty($data_marca)) {
                    $aux = MarcaVentor::create(["web_marcas" => $web_marcas]);
                    $echo["marca_id"] = $aux["id"];
                    $echo["marca"] = $web_marcas;
                    $aux = ModeloVentor::create(["modelo_y_a" => $modelo_y_a, "marca_id" => $aux["id"]]);
                    $echo["modelo_id"] = $aux["id"];
                } else {
                    $echo["marca_id"] = $data_marca["id"];
                    $echo["marca"] = $web_marcas;

                    $data_modelo = ModeloVentor::where('modelo_y_a','LIKE',$modelo_y_a)->where('marca_id',$data_marca["id"])->first();
                    if(empty($data_modelo)) {
                        $aux = ModeloVentor::create( [ "modelo_y_a" => $modelo_y_a, "marca_id" => $data_marca["id"] ] );
                        $echo["modelo_id"] = $aux["id"];
                    } else
                        $echo["modelo_id"] = $data_modelo["id"];
                }
                $data_familia = FamiliaVentor::where('usr_stmati','LIKE',$usr_stmati)->first();
                if(empty($data_familia)) {
                    $aux = FamiliaVentor::create( [ "usr_stmati" => $usr_stmati ] );
                    $echo["familia_id"] = $aux["id"];
                } else {
                    $data_familia->fill( [ "usr_stmati" => $usr_stmati ] );
                    $data_familia->save();
                    $echo["familia_id"] = $data_familia["id"];
                }
                $data_parte = PartesVentor::where('cod','LIKE',$parte)->where('familia_id',$echo["familia_id"])->first();
                if(empty($data_parte)) {
                    $aux = PartesVentor::create([ "cod" => $parte , "descrp" => $parte_dbf_ , "familia_id" => $echo["familia_id"] ] );
                    $echo["parte_id"] = $aux["id"];
                } else {
                    $data_parte->fill( [ 'descrp' => $parte_dbf_ ] );
                    $data_parte->save();
                    $echo["parte_id"] = $data_parte["id"];
                }
                ProductoVentor::create($echo);
            }
		}
        echo $total;
    }
    public function clientes() {
        set_time_limit(0);
        $total = 0;
        $property = [
            'nrocta',
            'nombre',
            'respon',
            'usrvtmcl',
            'usrvt_001',
            'usrvt_002',
            'direcc',
            'codpos',
            'descrp',
            'descr_001',
            'telefn',
            'nrofax',
            'direml',
            'nrodoc',
            'descr_002',
            'usrvt_003',
            'vnddor',
            'descr_003',
            'nrotel',
            'camail',
            'usrvt_004',
            'usrvt_005',
            'usrvt_006',
            'usrvt_007',
            'usrvt_008',
            'usrvt_009',
            'usrvt_010',
            'usrvt_011',
            'usrvt_012',
            'usrvt_013',
            'usrvt_014',
            'usrvt_015',
            'usrvt_016',
            'usrvt_017',
            'usrvt_018',
            'usrvt_019',
            'usrvt_020',
            'usrvt_021'
        ];
        
        $dbf = Table::fromFile('file/cnv_clientes.dbf');
		$pass = '$2y$10$ZbqDQTIEWuKiwgFdWUEdvePdjjLlpdLrP0ew7x0n5bcOSu.V20HPS';
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('clientesventor')->truncate();
		
		foreach ($dbf as $record) {
            $arrData = [];
            $nrodoc = $record->NRODOC;
            $dataC = Cliente::where('nrodoc','LIKE',$nrodoc)->first();
            $codpos = $descrp = $descr_001 = $usrvt_003 = $vnddor = $descr_003 = $nrotel = $camail = null;
            $usrvt_004 = $usrvt_005 = $usrvt_006 = $usrvt_007 = $usrvt_008 = $usrvt_009 = $usrvt_010 = $usrvt_011 = $usrvt_012 = $usrvt_013 = $usrvt_014 = $usrvt_015 = $usrvt_016 = $usrvt_017 = $usrvt_018 = $usrvt_019 = $usrvt_020 = $usrvt_021 = null;
            for( $j = 0 ; $j < count($property) ; $j++ ) {
                $valor = strtoupper( $property[$j] );
                if( $property[$j] == "localidad_id" || $property[$j] == "vendedor_id" ) continue;
                if( $property[$j] == "codpos" || 
                    $property[$j] == "descrp" || 
                    $property[$j] == "descr_001" || 
                    $property[$j] == "usrvt_003" || 
                    $property[$j] == "vnddor" || 
                    $property[$j] == "descr_003" || 
                    $property[$j] == "nrotel" || 
                    $property[$j] == "camail" || 
                    $property[$j] == "usrvt_004" || $property[$j] == "usrvt_005" || $property[$j] == "usrvt_006" || $property[$j] == "usrvt_007" || $property[$j] == "usrvt_008" || $property[$j] == "usrvt_009" || $property[$j] == "usrvt_010" || $property[$j] == "usrvt_011" || $property[$j] == "usrvt_012" || $property[$j] == "usrvt_013" || $property[$j] == "usrvt_014" || $property[$j] == "usrvt_015" || $property[$j] == "usrvt_016" || $property[$j] == "usrvt_017" || $property[$j] == "usrvt_018" || $property[$j] == "usrvt_019" || $property[$j] == "usrvt_020" || $property[$j] == "usrvt_021" ) {
                    ${$property[$j]} = $record->$valor;
                    continue;
                }
                $arrData[$property[$j]] = $record->$valor;
            }
            $total ++;
            $data = Vendedor::where('vnddor','LIKE',$vnddor)->first();
            if(!empty($data))
                $arrData["vendedor_id"] = $data["id"];
            $data = Localidad::where('codpos','LIKE',$codpos)->first();
            if(empty($data)) $aux = Localidad::create(["codpos" => $codpos,"descrp" => $descrp,"descr_001" => $descr_001]);
            else $aux = $data;
            $arrData["localidad_id"] = $aux["id"];
            $data = Vendedor::where('vnddor','LIKE',$vnddor)->first();
            $aux = null;
            if(!empty($data))
                $aux = $data["id"];
            $arrDataP["vendedor_id"] = $aux;
            $aux = null;
            $data = Transporte::where('tracod','LIKE',$usrvt_021)->first();
            if(!empty($data))
                $aux = $data["id"];
            $arrDataP["transporte_id"] = $aux;
            $arrData["transporte_id"] = $aux;
            if(empty($dataC)) {
                $aux = Cliente::create($arrData);
                $data = Usuario::where('username','LIKE',$arrData["nrodoc"])->first();
                if(empty($data))
                    Usuario::create( ['name' => $arrData["respon"], 'username' => $arrData["nrodoc"], 'password' => $pass, 'email' => $arrData["direml"], 'vendedor_id' => $arrDataP["vendedor_id"]] );
            } else {
                $aux = $dataC["id"];
                $data = Usuario::where('username','LIKE',$arrData["nrodoc"])->first();
                if(empty($data))
                    Usuario::create( ['name' => $arrData["respon"], 'username' => $arrData["nrodoc"], 'password' => $pass, 'email' => $arrData["direml"], 'vendedor_id' => $arrDataP["vendedor_id"]] );
                else {
                    $data->fill( [ 'name' => $arrData["respon"],'email' => $arrData["direml"], 'vendedor_id' => $arrDataP["vendedor_id"] ] );
                    $data->save();
                }
			}

        }
        echo $total;
    }
    public function vendedores() {
        set_time_limit(0);
        $total = 0;
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('vendedoresventor')->truncate();
        
		$property = [
            'vnddor',
            'descrp',
            'natmer',
            'nrotel',
            'mail'
        ];
        $dbf = Table::fromFile('file/cnv_Vendedores.dbf');
        
        $pass = '$2y$10$ZbqDQTIEWuKiwgFdWUEdvePdjjLlpdLrP0ew7x0n5bcOSu.V20HPS';
        foreach ($dbf as $record) {
            if(empty($record->NATMER) && empty($record->MAIL))
                continue;
            $total ++;
            $vnddor = $record->VNDDOR;
            $data = Vendedor::where('vnddor','LIKE',$vnddor)->first();
            if(empty($data)) {
                $arrData = [];
                for( $j = 0 ; $j < count($property) ; $j++ ) {
                    $valor = strtoupper($property[$j]);
                    $arrData[$property[$j]] = $record->$valor;
                }
                $aux = Vendedor::create($arrData);
                $data = User::where('username','LIKE','VND_{$arrData["natmer"]}')->first();
                if(empty($data))
                    User::create( [ 'name' => $arrData["descrp"], 'username' => 'VND_{$arrData["natmer"]}', 'password' => $pass, 'is_admin' => 2 ] );
            }
        }
        echo $total;
    }
    public function usuarios() {
        set_time_limit(0);
        $total = 0;
        $dbf = Table::fromFile('file/USR_EMPLEADOS.dbf');
		$pass = '$2y$10$ZbqDQTIEWuKiwgFdWUEdvePdjjLlpdLrP0ew7x0n5bcOSu.V20HPS';
		$property		= [ "nroleg" , "name" , "username" , "direma" ];
		
		foreach ($dbf as $record) {
            $arrData = [];
            $nrodoc = $record->NRODO2;
            $data = User::where('username','LIKE',"EMP_{$nrodoc}")->first();
            for( $j = 0 ; $j < count($property) ; $j++ ) {
                $valor = strtoupper( $property[$j] );
                $key = $property[$j];
                if($key == "name")
                    $valor = "NOMBRE";
                if($key == "username")
                    $valor = "NRODO2";
                $arrData[$key] = $record->$valor;
            }
            $total ++;
            $arrData["username"] = "EMP_{$arrData["username"]}";
            if(empty($data))
                User::create( ['name' => $arrData["name"], 'username' => $arrData["username"], 'password' => $pass, 'is_admin' => 11, 'direma' => $arrData["direma"]] );
			else {
                $data->fill( ['name' => $arrData["name"], 'direma' => $arrData["direma"]] );
				$data->save();
			}
		}
        echo $total;
    }
    public function transporte() {
        set_time_limit(0);
        $total = 0;
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('transportesventor')->truncate();

		$property = [
            'tracod',
            'descrp',
            'tradir',
            'telefn',
            'respon'
        ];
        $dbf = Table::fromFile('file/TRALST.dbf');

		foreach ($dbf as $record) {
            $arrData = [];
            for( $j = 0 ; $j < count($property) ; $j++ ) {
                $valor = strtoupper( $property[$j] );
                $arrData[$property[$j]] = $record->$valor;
            }
            $total ++;
            Transporte::create($arrData);
        }
        echo $total;
    }
}
