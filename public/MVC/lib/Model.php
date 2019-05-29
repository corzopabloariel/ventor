<?php
class Model {
    private static $instance = null;
    public $table;
    public $id;

    private function __construct() {
        if(empty($this->__get("table")))
            $this->__set("table",strtolower(get_class($this)));
        //$this->model = new self();
    }
    public static function getInstance(){
        if(self::$instance === null)
            self::$instance = new self;
        return self::$instance;
    }

    public static function get_property($t = 0) {
        $m = new static();
        $arr = get_class_vars(get_class($m));
        unset($arr["id"]);
        unset($arr["table"]);
        unset($arr["instance"]);
        if($t) {
            $r = [];
            foreach($arr AS $k => $v)
                $r[] = strtolower($k);
            return $r;
        }
        return $arr;
    }

    public function __get($property) {
		if((property_exists($this, $property)))
			return $this->$property;
    }
    public function __set($property, $value) {
        if((property_exists($this, $property)))
            $this->$property = $value;
    }
    
    public static function find($id) {
        $m = new static();
        //$m->table = strtolower(get_class($m));
        //print_r($id);
        return self::findOneBy($id);
    }

    public static function create($Arr_value, $tipo = 0) {
        $m = new static();
        $Arr_new = [];
        foreach(self::get_property() AS $k => $v) {
            if(isset($Arr_value[strtolower($k)]))
                $Arr_new[$k] = $Arr_value[strtolower($k)];
        }
        $Arr_new["id"] = "nulo";
        
        return DB::set_uno($m->table,$Arr_new, $tipo);
    }

    public static function save($Arr_value) {
        $m = new static();
        $table = $m->table;
        
        foreach($m AS $k => $v) {
            if(isset($Arr_value[$k]))
                $m->$k = $Arr_value[$k];
            else
                unset($m->$k);
        }
        $m->id = $Arr_value["id"];
        //print_r($m);die();
        return DB::save($table,$m);
    }

    public static function where($column, $value) {
        return self::findOneBy($value,$column);
    }
    /*
     * Funcion findOneBy: Devuelve un objeto de la clase o false
     * VALUE  = Valor a buscar en la tabla
     * COLUMN = Columna donde buscar el valor. Por default did.
     * WHERE  = Sentencia para acotar la búsqueda; se debe poner nombre
     *          y valor; si son varias, se acompaña con su concatenación
     *          adecuada (AND / OR).
     * ORDER  = Sentencia para ordenar los registros.
     */
    public static function findOneBy($value,$column = "id",$where = "",$orden = "") {
        $m = new static();
        
        $dato = DB::get_uno($m->table,$column,$value, false, $where, $orden);
        //print_r($dato);
        //$dato = R::findOne($m->table,"{$column} = ? {$where} AND elim = 0 {$order} LIMIT 1",Array($value));
        if($dato) {
            foreach(self::get_property() AS $k => $v) {
                $m->__set($k,$dato[$k]);
            }
            $m->__set("id",$dato["id"]);
            return $m;
        } else return false;
    }

    /*
     * Función guardar
     * Devuelve objeto determinado
     */
    public static function guardar($arr) {
        $model = new static();
        $data = R::xdispense($model->table);
        foreach ($arr as $key => $value)
            $data[$key] = $value;
        
        if(isset($data["fecha"])) $data["fecha"] = date("Ymd");
        
        return self::findOneBy(R::store($data),"id");//R::load($model->table, $id);
    }

    /*
     * Función baja
     */
    public static function erase_($id) {
        $model = new static();
        $data = R::findOne($model->table,"id LIKE ?",Array($id));
        $data["elim"] = 1;
        R::store($data);
    }
}
