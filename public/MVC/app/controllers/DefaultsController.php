<?php

class DefaultsController extends Controller {

	public function __construct() {}
		//php init 4500
	static public function indexAction($param) {
		$Arr = [];
		foreach (new DirectoryIterator(APP_PATH."file/") as $file) {
			if($file->isDot()) continue;
			$Arr[] = "{$file->getFilename()}";
		}
		Response::render("default/home",["archivos" => $Arr]);
	}

	public function subirAction($param) {
		if(isset($_FILES["archivo"])) {
			$requestData = $_REQUEST;
			$archivo = $_FILES["archivo"];

			$fileTmpPath = $archivo['tmp_name'];
			$fileName = $archivo['name'];
			$fileSize = $archivo['size'];
			$fileType = $archivo['type'];
			$fileNameCmps = explode(".", $fileName);
			$fileExtension = end($fileNameCmps);
			$newFileName = $requestData["nombre"];
			$path = $_SERVER['DOCUMENT_ROOT'] . '/ventor/app/file/';
			
			if (!file_exists($path))
			mkdir($path, 0777, true);
				
			$dest_path = $path . $newFileName;
			move_uploaded_file($fileTmpPath, $dest_path);
		}
		
		Response::render("default/subir",["archivo" => $param[1]]);
	}

	public function productoAction($param) {
		$total_registros = 0;
		$property = Producto::get_property(1);
		$total = 0;
		
		$fichero_dbf = APP_PATH . 'file/cnv_precios.dbf';
		$conex       = dbase_open($fichero_dbf, 0);
		$sql = "DELETE FROM `productosventor`";
		DB::consulta($sql);//ELIMINO TODOS LOS REGISTROS
		$sql = "TRUNCATE TABLE `productosventor`";
		DB::consulta($sql);
		if( $conex ) {
			$arrData = [];
			$total_registros = dbase_numrecords($conex);
			
			for ( $i = 1 ; $i <= $total_registros ; $i++ ) {
				$dataDBF = dbase_get_record($conex,$i);
				$codigo = trim( $dataDBF[0] );
				$nombre = trim( $dataDBF[3] );
				$sql = "SELECT * FROM `productosventor` WHERE stmpdh_art LIKE '%{$codigo}%' AND stmpdh_tex LIKE '%{$nombre}%' LIMIT 1";
				$data = DB::consulta($sql);
				
				if(empty($data)) {
					$total ++;
					$web_marcas = null;
					$modelo_y_a = null;

					$parte = null;
					$parte_dbf_ = null;

					$usr_stmati = null;

					for( $j = 0 ; $j < count( $property ) ; $j++ ) {
						if($property[$j] == "familia_id" || $property[$j] == "parte_id" || $property[$j] == "modelo_id") continue;
						$valor = trim( $dataDBF[$j] );
						$valor = mb_convert_encoding ($valor, "ISO-8859-1");

						if($property[$j] == "web_marcas" || $property[$j] == "parte" || $property[$j] == "parte_dbf_" || $property[$j] == "modelo_y_a" || $property[$j] == "usr_stmati") {
							${$property[$j]} = $valor;
							//var_dump(${$property[$j]});
							continue;
						}
	
						if( strtolower( $property[$j] ) == "precio" || strtolower( $property[$j] ) == "cantminvta" || strtolower( $property[$j] ) == "usr_stmpdh" )
							$valor = floatval( $valor );
						if( strtolower( $property[$j] ) == "fecha_ingr" ) {
							if ( strpos( $valor, ".m." ) == false ) {
								$valor = null;
							} else {
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
					if(empty($modelo_y_a))
						$modelo_y_a = "Sin especificar";
					$sql = "SELECT * FROM marcasventor WHERE web_marcas LIKE '%{$web_marcas}%' LIMIT 1";
					$data_marca = DB::consulta($sql);
					if(empty($data_marca)) {
						$aux = Marca::create(["web_marcas" => $web_marcas],0);
						$aux = Modelo::create(["modelo_y_a" => $modelo_y_a, "marca_id" => $aux],0);
						$echo["modelo_id"] = $aux;
					} else {
						$sql = "SELECT * FROM modeloventor WHERE modelo_y_a LIKE '%{$modelo_y_a}%' AND marca_id = {$data_marca["id"]} LIMIT 1";
						$data_modelo = DB::consulta($sql);
						if(empty($data_modelo)) {
							$aux = Modelo::create(["modelo_y_a" => $modelo_y_a, "marca_id" => $data_marca["id"]],0);
							$echo["modelo_id"] = $aux;
						} else
							$echo["modelo_id"] = $data_modelo["id"];
					}
					
					$sql = "SELECT * FROM familiasventor WHERE usr_stmati LIKE '%{$usr_stmati}%' LIMIT 1";
					$data_familia = DB::consulta($sql);//var_dump($usr_stmati);die();
					if(empty($data_familia)) {
						$aux = Familia::create(["usr_stmati" => $usr_stmati],0);
						$echo["familia_id"] = $aux;
					} else 
						$echo["familia_id"] = $data_familia["id"];
						
					$sql = "SELECT * FROM partesventor WHERE cod LIKE '%{$parte}%' AND familia_id = {$echo["familia_id"]} LIMIT 1";
					$data_parte = DB::consulta($sql);
					if(empty($data_parte)) {
						$aux = Parte::create(["cod" => $parte, "descrp" => $parte_dbf_, "familia_id" => $echo["familia_id"]],0);
						$echo["parte_id"] = $aux;
					} else {
						$sql = "UPDATE `partesventor` SET descrp = `{$parte_dbf_}` WHERE id = {$data_parte["id"]}";
						DB::consulta($sql);
						$echo["parte_id"] = $data_parte["id"];
					}
					Producto::create($echo,1);
				}/* else {
					$web_marcas = null;
					$modelo_y_a = null;

					$parte = null;
					$parte_dbf_ = null;

					$usr_stmati = null;

					$echo["id"] = $data["id"];
					for( $j = 0 ; $j < count( $property ) ; $j++ ) {
						if($property[$j] == "familia_id" || $property[$j] == "parte_id" || $property[$j] == "modelo_id") continue;
						$valor = trim( $dataDBF[$j] );
						$valor = mb_convert_encoding ($valor, "ISO-8859-1");

						if($property[$j] == "web_marcas" || $property[$j] == "parte" || $property[$j] == "parte_dbf_" || $property[$j] == "modelo_y_a" || $property[$j] == "usr_stmati") {
							${$property[$j]} = $valor;
							//var_dump(${$property[$j]});
							continue;
						}
	
						if( strtolower( $property[$j] ) == "precio" || strtolower( $property[$j] ) == "cantminvta" || strtolower( $property[$j] ) == "usr_stmpdh" )
							$valor = floatval( $valor );
						if( strtolower( $property[$j] ) == "fecha_ingr" ) {
							if ( strpos( $valor, ".m." ) == false ) {
								$valor = null;
							} else {
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
					if(empty($modelo_y_a))
						$modelo_y_a = "Sin especificar";
					$sql = "SELECT * FROM marcasventor WHERE web_marcas LIKE '%{$web_marcas}%' LIMIT 1";
					$data_marca = DB::consulta($sql);
					if(empty($data_marca)) {
						$aux = Marca::create(["web_marcas" => $web_marcas],0);
						$aux = Modelo::create(["modelo_y_a" => $modelo_y_a, "marca_id" => $aux],0);
						$echo["modelo_id"] = $aux;
					} else {
						$sql = "SELECT * FROM modeloventor WHERE modelo_y_a LIKE '%{$modelo_y_a}%' AND marca_id = {$data_marca["id"]} LIMIT 1";
						$data_modelo = DB::consulta($sql);
						if(empty($data_modelo)) {
							$aux = Modelo::create(["modelo_y_a" => $modelo_y_a, "marca_id" => $data_marca["id"]],0);
							$echo["modelo_id"] = $aux;
						} else
							$echo["modelo_id"] = $data_modelo["id"];
					}
					
					$sql = "SELECT * FROM familiasventor WHERE usr_stmati LIKE '%{$usr_stmati}%' LIMIT 1";
					$data_familia = DB::consulta($sql);//var_dump($usr_stmati);die();
					if(empty($data_familia)) {
						$aux = Familia::create(["usr_stmati" => $usr_stmati],0);
						$echo["familia_id"] = $aux;
					} else 
						$echo["familia_id"] = $data_familia["id"];

					$sql = "SELECT * FROM partesventor WHERE cod LIKE '%{$parte}%' AND familia_id = {$echo["familia_id"]} LIMIT 1";
					$data_parte = DB::consulta($sql);
					if(empty($data_parte)) {
						$aux = Parte::create(["cod" => $parte, "descrp" => $parte_dbf_, "familia_id" => $echo["familia_id"]],0);
						$echo["parte_id"] = $aux;
					} else {
						$sql = "UPDATE `partesventor` SET descrp = `{$parte_dbf_}` WHERE id = {$data_parte["id"]}";
						DB::consulta($sql);
						$echo["parte_id"] = $data_parte["id"];
					}
					
					Producto::save($echo);
					//print_r();
					//die();
				}*/
			}
		}
		Response::render("default/index",["total" => $total]);
	}

	public function usuariosAction($param) {
		$fichero_dbf 	= APP_PATH . 'file/USR_EMPLEADOS.dbf';
		$conex       	= dbase_open($fichero_dbf, 0);
		$pass 			= '$2y$10$ZbqDQTIEWuKiwgFdWUEdvePdjjLlpdLrP0ew7x0n5bcOSu.V20HPS';
		$property		= [ "nroleg" , "name" , "username" , "direma" ];
		
		if( $conex ) {
			$total_registros = dbase_numrecords($conex);
			
			for ( $i = 1 ; $i <= $total_registros ; $i++ ) {
				$arrData = [];
				$dataDBF = dbase_get_record($conex,$i);
				$nrodoc = trim( $dataDBF[2] );
				$sql = "SELECT * FROM `users` WHERE username LIKE 'EMP_%{$nrodoc}%' LIMIT 1";
				$data = DB::consulta($sql);
				for( $j = 0 ; $j < count($property) ; $j++ ) {
					$valor = trim( $dataDBF[$j] );
					$arrData[$property[$j]] = $valor;
				}
				$arrData["username"] = "EMP_{$arrData["username"]}";
				if(empty($data)) {				
					$sql = "INSERT INTO `users` (`name`,`username`,`password`,`is_admin`,`direma`) VALUES ('{$arrData["name"]}','{$arrData["username"]}','{$pass}',11,'{$arrData["direma"]}')";
					DB::consulta($sql);
				} else {
					$sql = "UPDATE `users` SET `name` = '{$arrData["respon"]}',`direma` = '{$arrData["direma"]}' WHERE username LIKE '{$arrData["username"]}'";
					DB::consulta($sql);
				}
			}
			Response::render("default/index",["total" => $total_registros]);
		}
	}
	
	public function clientesAction($param) {
		$total 			= 0;
		$property 		= Cliente::get_property(1);
		$fichero_dbf 	= APP_PATH . 'file/cnv_clientes.dbf';
		$conex       	= dbase_open($fichero_dbf, 0);
		$pass 			= '$2y$10$ZbqDQTIEWuKiwgFdWUEdvePdjjLlpdLrP0ew7x0n5bcOSu.V20HPS';
		$sql = "DELETE FROM `clientesventor`";
		DB::consulta($sql);//ELIMINO TODOS LOS REGISTROS
		$sql = "TRUNCATE TABLE `clientesventor`";
		DB::consulta($sql);
		
		if( $conex ) {
			$total_registros = dbase_numrecords($conex);
			
			for ( $i = 1 ; $i <= $total_registros ; $i++ ) {
				$arrData = [];
				$dataDBF = dbase_get_record($conex,$i);
				$nrodoc = trim( $dataDBF[13] );
				
				$sql = "SELECT * FROM `clientesventor` WHERE nrodoc LIKE '%{$nrodoc}%' LIMIT 1";
				$dataC = DB::consulta($sql);
				//print_r($data);die();
				$codpos = $descrp = $descr_001 = $usrvt_003 = $vnddor = $descr_003 = $nrotel = $camail = null;
				$usrvt_004 = $usrvt_005 = $usrvt_006 = $usrvt_007 = $usrvt_008 = $usrvt_009 = $usrvt_010 = $usrvt_011 = $usrvt_012 = $usrvt_013 = $usrvt_014 = $usrvt_015 = $usrvt_016 = $usrvt_017 = $usrvt_018 = $usrvt_019 = $usrvt_020 = $usrvt_021 = null;
				for( $j = 0 ; $j < count($property) ; $j++ ) {
					$valor = trim( $dataDBF[$j] );
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
						${$property[$j]} = $valor;
						continue;
					}

					$arrData[$property[$j]] = $valor;
				}
				$sql = "SELECT * FROM `vendedoresventor` WHERE vnddor LIKE '%{$vnddor}%' LIMIT 1";
				$data = DB::consulta($sql);
				if(!empty($data))
					$arrData["vendedor_id"] = $data["id"];
				//print_r($arrData);die();

				$sql = "SELECT * FROM `localidades` WHERE codpos LIKE '%{$codpos}%' LIMIT 1";
				$data = DB::consulta($sql);
				
				if(empty($data)) $aux = Localidad::create(["codpos" => $codpos,"descrp" => $descrp,"descr_001" => $descr_001],0);
				else $aux = $data["id"];
				$arrData["localidad_id"] = $aux;
				
				$sql = "SELECT * FROM `vendedoresventor` WHERE vnddor LIKE '%{$vnddor}%' LIMIT 1";
				$data = DB::consulta($sql);
				$aux = null;
				if(!empty($data))
					$aux = $data["id"];
				$arrDataP["vendedor_id"] = $aux;

				$sql = "SELECT * FROM `transportesventor` WHERE tracod LIKE '%{$usrvt_003}%' LIMIT 1";
				$data = DB::consulta($sql);
				if(!empty($data))
					$aux = $data["id"];
				$arrDataP["transporte_id"] = $aux;
				$arrData["transporte_id"] = $aux;
				if(empty($dataC)) {
					$aux = Clienteventor::create($arrData,0);
					$sql = "SELECT * FROM `users` WHERE username LIKE '%{$arrData["nrodoc"]}%' LIMIT 1";
					$data = DB::consulta($sql);
					if(empty($data)) {
						$sql = "INSERT INTO `users` (`name`,`username`,`password`,`email`,`vendedor_id`) VALUES ('{$arrData["respon"]}','{$arrData["nrodoc"]}','{$pass}','{$arrData["direml"]}',{$arrDataP["vendedor_id"]})";
						DB::consulta($sql);
					}
				} else {
					$aux = $dataC["id"];
					$sql = "SELECT * FROM `usuarios` WHERE username LIKE '%{$arrData["nrodoc"]}%' LIMIT 1";
					$data = DB::consulta($sql);
					if(empty($data)) {
						$sql = "INSERT INTO `usuarios` (`name`,`username`,`password`,`email`,`vendedor_id`) VALUES ('{$arrData["respon"]}','{$arrData["nrodoc"]}','{$pass}','{$arrData["direml"]}',{$arrDataP["vendedor_id"]})";
						DB::consulta($sql);
					} else {
						$sql = "UPDATE `usuarios` SET `name` = '{$arrData["respon"]}',`email` = '{$arrData["direml"]}',`vendedor_id` = {$arrDataP["vendedor_id"]} WHERE username LIKE '{$arrData["nrodoc"]}'";
						DB::consulta($sql);
					}
				}
				$arrDataP = [];
				$arrDataP["cliente_id"] = $aux;
				
				//Pedido::create($arrDataP,1);
				
			}

			Response::render("default/index",["total" => $total_registros]);
		}
	}

	public function vendedoresAction($param) {
		$total 			= 0;
		$property 		= Vendedor::get_property(1);
		$fichero_dbf 	= APP_PATH . 'file/cnv_Vendedores.dbf';
		$conex       	= dbase_open($fichero_dbf, 0);
		$pass 			= '$2y$10$ZbqDQTIEWuKiwgFdWUEdvePdjjLlpdLrP0ew7x0n5bcOSu.V20HPS';
		//$sql = "DELETE FROM `clientesventor` WHERE username LIKE '%VND%'";
		//DB::consulta($sql);//ELIMINO TODOS LOS REGISTROS
		if( $conex ) {
			$total_registros = dbase_numrecords($conex);
			for ( $i = 1 ; $i <= $total_registros ; $i++ ) {
				$arrData = [];
				$dataDBF = dbase_get_record($conex,$i);
				$vnddor = trim( $dataDBF[0] );
				$sql = "SELECT * FROM `vendedoresventor` WHERE vnddor LIKE '%{$vnddor}%' LIMIT 1";
				$data = DB::consulta($sql);
				for( $j = 0 ; $j < count($property) ; $j++ ) {
					$valor = trim( $dataDBF[$j] );
					$arrData[$property[$j]] = $valor;
				}
				if(empty($arrData["natmer"]) && empty($arrData["mail"])) continue;
				$total ++;
				if(empty($data)) {
					$aux = Vendedor::create($arrData,0);
					$sql = "INSERT INTO `users` (`name`,`username`,`password`,`is_admin`) VALUES ('{$arrData["descrp"]}','VND_{$arrData["natmer"]}','{$pass}',2)";
					DB::consulta($sql);
				}
			}
		}
		Response::render("default/index",["total" => $total]);
	}

	public function transporteAction($param) {//WHERE parte_id IS NULL
		$total 			= 0;
		$property 		= Transporte::get_property(1);
		$fichero_dbf 	= APP_PATH . 'file/TRALST.dbf';
		$conex       	= dbase_open($fichero_dbf, 0);
		$sql = "DELETE FROM `transportesventor`";
		DB::consulta($sql);//ELIMINO TODOS LOS REGISTROS
		$sql = "TRUNCATE TABLE `transportesventor`";
		DB::consulta($sql);

		if( $conex ) {
			$total_registros = dbase_numrecords($conex);
			for ( $i = 1 ; $i <= $total_registros ; $i++ ) {
				$arrData = [];
				$dataDBF = dbase_get_record($conex,$i);

				for( $j = 0 ; $j < count($property) ; $j++ ) {
					$valor = trim( $dataDBF[$j] );
					$arrData[$property[$j]] = $valor;
				}
				$total ++;
				Transporte::create($arrData,0);
			}
		}
		Response::render("default/index",["total" => $total]);
	}
	
	public function modelosAction($param) {//WHERE parte_id IS NULL
		$sql = "SELECT id,web_marcas,modelo_y_a FROM `productosventor` WHERE modelo_id IS NULL GROUP BY modelo_y_a ORDER BY web_marcas";
		$data = DB::consulta($sql);
		die();
		$property = Marca::get_property(1);
		$property2 = Modelo::get_property(1);
		
		foreach($data AS $i => $v) {
			$echo = [];
			$m = Marca::where("web_marcas",$v["web_marcas"]);
			if(empty($m)) {
				foreach($property AS $p) //MARCA
					$echo[$p] = $v[$p];
				$aux = Marca::create($echo,0);
			} else
				$aux = $m->id;
			$mod = DB::consulta("SELECT * FROM modeloventor WHERE modelo_y_a LIKE '{$v["modelo_y_a"]}' AND marca_id = {$aux} LIMIT 1");
			if(empty($mod)) {
				$echo2 = [];
				$echo2["marca_id"] = $aux;
				foreach($property2 AS $p) {//MODELO
					if($p == "marca_id") continue;
					$echo2[$p] = $v[$p];
					if(empty($v[$p]))
						$echo2[$p] = "Sin especificar";
				}
				$aux = Modelo::create($echo2,0);
			} else {
				$aux = $mod["id"];
			}
			$sql = "UPDATE `productosventor` SET modelo_id = {$aux} WHERE web_marcas LIKE '{$v["web_marcas"]}' AND modelo_y_a LIKE '{$v["modelo_y_a"]}'";
			//echo "{$sql}<br/>";
			DB::consulta($sql);
			//	print_r(["id" => $p,"parte_id" => $aux["id"]]);die();
			//	$r = DB::set_uno("productosventor",["id" => $p,"parte_id" => $aux["id"]]);
		}
		Response::render("default/index");
	}

	public function familiasAction($param) {
		$sql = "SELECT usr_stmati, id FROM `productosventor` GROUP BY usr_stmati";
		$data = DB::consulta($sql);
		
		$property = Familia::get_property(1);
		foreach($data AS $i => $v) {
			foreach($property AS $p) //MARCA
				$echo[$p] = $v[$p];
			$aux = Familia::create($echo,0);
			$sql = "UPDATE `productosventor` SET familia_id = {$aux} WHERE usr_stmati LIKE '{$v["usr_stmati"]}'";
			//echo "{$sql}<br/>";
			DB::consulta($sql);
		}
	}
}
