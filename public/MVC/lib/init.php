<?php
require SYS_PATH . "App.php";
require SYS_PATH . "Controller.php";
require SYS_PATH . "Response.php";
require SYS_PATH . "DB.php";
require SYS_PATH . "Model.php";
require SYS_PATH . "Sessions.php";
require SYS_PATH . "toolbox.php";

require SYS_PATH . "XBase/Memo.php";
require SYS_PATH . "XBase/Table.php";
require SYS_PATH . "XBase/Column.php";
require SYS_PATH . "XBase/Record.php";

foreach (new DirectoryIterator(APP_PATH."models/") as $file) {
	if($file->isDot()) continue;
	require APP_PATH."models/{$file->getFilename()}";
}

foreach (new DirectoryIterator(APP_PATH."controllers/") as $file) {
	if($file->isDot()) continue;
	require APP_PATH."controllers/{$file->getFilename()}";
}