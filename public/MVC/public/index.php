<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*
 * RUTA HTTP
 * Indica la ubicación del sistema.
 * Todo pasa por aquí.
 * -------------------
 * IMG DEFAULT
 * Ubicación de una imagen jpg por defecto.
 */
/**
 * LIBRERIAS & MÁS
 * https://www.jsdelivr.com/
 * https://jquery.com/
 * https://getbootstrap.com/
 * https://select2.org/
 */
chdir(dirname(__DIR__));

define("SYS_PATH", "lib/");
define("APP_PATH", "app/");
define("RUTA_HTTP","http://localhost/ventor/");

require SYS_PATH."init.php";
$app = new App;
