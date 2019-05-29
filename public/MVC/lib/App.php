<?php
require_once "default.php";
class App {
    protected $controller   = "";
    protected $method       = "";
    protected $params       = [];

    public function __construct() {
        DB::init();
        Session::createSession();

        $url = $this->parseUrl();
        $clase = ucfirst(strtolower($url[0]));
        if(class_exists($clase)) {
            $controllerName = "{$clase}Controller";
            if(file_exists(APP_PATH."controllers/{$controllerName}.php")) {
                $this->controller = $controllerName;
                unset($url[0]);
                require_once APP_PATH."controllers/{$this->controller}.php";
            }
        } else {
            //throw new Exception("Error. No existe {$url}");
            $controllerName = "{$clase}Controller";
            $this->controller = $controllerName;
        }
        if(!empty($url)) {
            
            if(count($url) > 1) {
                $methodName = strtolower($url[1])."Action";
                
                if(in_array("adm",$url) && count($url) > 2) {
                    $controllerName = "{$url[1]}Controller";
                    $methodName = strtolower($url[2])."Action";
                    unset($url[1]);
                    unset($url[2]);
                }
                $this->controller = $controllerName;
                if(method_exists($this->controller,$methodName)){
                    $this->method = $methodName;
                    unset($url[1]);
                } else
                    $this->method = METHOD_NOT_FOUND;
                
                //die($this->method);
            } else {
                if(method_exists($this->controller,METHOD_DEFAULT))
                    $this->method = METHOD_DEFAULT;
                else
                    $this->method = METHOD_NOT_FOUND;
            }
        } else {
            $this->method = METHOD_DEFAULT;
        }
        $this->controller = DEFAULT_CONTROLLER;
        $this->params = $url ? array_values($url) : $this->params;
        
        //die($this->controller);
        call_user_func_array([$this->controller,$this->method],[$this->params]);
    }

    public function parseUrl() {
        if(isset($_GET["url"]))
            return explode("/",filter_var(rtrim($_GET["url"],"/"),FILTER_SANITIZE_URL));
    }
}
