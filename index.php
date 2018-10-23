<?php
/**
 * Created by PhpStorm.
 * User: Natali
 * Date: 14.10.2018
 * Time: 16:40
 */
define('ROOT', dirname(__FILE__));
define('DATABASE_INSTALLED', true);

// Local Site
define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '');
define('DATABASE', 'moviestorage');

// Hosting http://moviestor-cc-ua.1gb.ua/
//define('HOST', '');
//define('USER', '');
//define('PASSWORD', '');
//define('DATABASE', '');

function __autoload($className) {
	$ds = DIRECTORY_SEPARATOR;
	$foldersList = array('classes', 'views', 'model');
	$pathBase = $_SERVER['DOCUMENT_ROOT'].$ds;
	foreach($foldersList as $folder) {
		$path = $pathBase.$folder.$ds.$className.'.php';
		if(file_exists($path)) {
			require_once $path;
			return true;
		}
	}
	return false;
}
if(!DATABASE_INSTALLED) {
	$db = new DB(HOST, USER, PASSWORD, DATABASE);
	$db->install();
}
session_start();
$router = new Router();
$router->init();