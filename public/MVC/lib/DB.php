<?php
include_once('config.php');
//include_once('ext/rb-mysql.php');
include_once('ext/rb-mysql.php');
class DB {
	static $mysqli = null;
	static $pdo = null;

	static function init() {
		R::setup("mysql:host=".CONFIG_HOST.";dbname=".CONFIG_BD,CONFIG_USER,CONFIG_PASS);
		R::ext('xdispense', function( $type ){ return R::getRedBean()->dispense( $type ); });

		self::$mysqli = new mysqli(CONFIG_HOST, CONFIG_USER, CONFIG_PASS, CONFIG_BD);
		self::$mysqli->set_charset('utf8');
		self::$pdo = new PDO('mysql:' . CONFIG_HOST . '=localhost;dbname=' . CONFIG_BD, CONFIG_USER, CONFIG_PASS);
	}

	public static function createData($d) {
        $tables = R::inspect();
        $entidad = $d["entidad"];
		$ARR_attr = $d["objeto"];
		$values = $d["values"];
        if(in_array($entidad, $tables))
            response(200, 'ok', $values);
        else {
			
            $aux = R::xdispense($entidad);
            foreach ($ARR_attr as $attr => $tipo) {
                if(is_null($tipo)) continue;
				$valor = "";
                if(isset($values[$tipo]))
                    $valor = $values[$tipo];
                if($attr != "id")
                    $aux->$attr = $valor;
            }
            R::store($aux);
            R::wipe($entidad);
            response(200, "TABLA {$entidad} creada", $values);
        }
	}
	
	public static function get_uno($e,$column,$value, $response = true, $where = "", $orden = "") {
		$data = R::findOne($e,"{$column} LIKE ? {$where} {$orden}", [$value]);
		
		if($response)
			response(200,empty($data) ? "V='{$value}' / C='{$column}'  no encontrado en {$e}" : "Dato encontrado",$data);
		else
			return $data;
	}
	public static function save($table, $obj) {
		$data = self::get_uno($table,"id",$obj->id, false);
		
		foreach($obj AS $k => $i) {
			//if(isset($obj->$k))
				$data[$k] = $obj->$k;
		}
		return R::store($data);
	}
	public static function create($data) {
		$Arr_new = [];
		
        foreach(self::get_property() AS $k => $v) {
            if(isset($Arr_value[$k]))
                $Arr_new[$k] = $Arr_value[$k];
		}
		var_dump($Arr_new);
		die();
	}
	public static function consulta($sql) {
		if(strpos($sql, "SELECT") !== false) {
			$Arr = [];
			if($queryRecords = self::$mysqli->query($sql)) {
				if(strpos($sql, "LIMIT 1") !== false)
					return $queryRecords->fetch_assoc();
				
				while($tabla = $queryRecords->fetch_assoc()) {
					$Arr[$tabla["id"]] = $tabla;
				}
			}
			//self::$mysqli->close();

			return $Arr;
		} else if(strpos($sql, "UPDATE") !== false) {
			self::$mysqli->query($sql);
		} else if(strpos($sql, "TRUNCATE") !== FALSE) {
			$statement = self::$pdo->prepare("SET FOREIGN_KEY_CHECKS=0; {$sql}");
			$statement->execute();
		} else
			self::$mysqli->query($sql);
	}
	/** PHP INI - 1500seg */
	public static function set_uno($e,$obj,$mysql = 0) {
		if($mysql) {
			$values = "";
			$attr = "";
			if(isset($obj["id"])) {
				if($obj["id"] == "nulo")
					unset($obj["id"]);
			}
			foreach($obj AS $k => $v) {
				if(!empty($attr)) $attr .= ",";
				if(!empty($values)) $values .= ",";
				$values .= "'{$v}'";
				$attr .= "`{$k}`";
			}
			$sql = "INSERT INTO {$e} ($attr) VALUES ($values)";
			//echo "{$sql}<br/>";
			self::$mysqli->query($sql);

		} else {
			$bean = R::xdispense($e);
			unset($obj['id']);
				
			foreach($obj as $k => $v){
				
				$valor = $obj[$k];
				$bean[strtoupper($k)] = $valor;
			}
			return R::store($bean);
		}
		//return true;
	}
}
