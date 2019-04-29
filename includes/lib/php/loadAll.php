<?php
//ini_set('display_errors', 1);
ini_set('display_errors', 0);
//error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

session_start();
if(isset($_GET['exit'])){
	unset($_SESSION);
	session_destroy();
	session_start();
}
date_default_timezone_set('Europe/Madrid');
setlocale(LC_ALL, "es_ES"); //idioma de los date() en español

//Cargamos resto de librerias php
// $php_libs = array(
//     "loadDoctrine.php",
//     "loadOthers.php",
//     "loadEmail.php",
//     "loadForms.php"
// );
$php_libs = array(
	"loadDoctrine.php",
    "loadOthers.php",
    "loadForms.php"
);
foreach ($php_libs as $pathlib) {
    include_once $pathlib;
}

/*
	if
la variable $login_page solo existe en el login
si no estas en el login y no existe la sesion
te manda al login
	
	elseif
si estas en el login y existe la sesion
te manda al index
*/
if(isset($_intranet)){
	if(!isset($_loginPage) && !isset($_SESSION['user'])){
		header('Location: login');
	}elseif(isset($_loginPage) && isset($_SESSION['user'])){
		header('Location: index');
	}
}

$_tablas = Doctrine_Core::getLoadedModels();
$_configs = Doctrine_Query::create()->from('Configs')->execute();

$_configs=(object)$_configs->toArray();
$_config = new stdClass();
$_configTitle = new stdClass();
foreach($_configs as $c){
	$_config->$c['param'] = $c['value'];
	$_configTitle->$c['param'] = $c['title'];
}

//EN DESUSO: $_config->activeModules = array_values(array_filter(explode(";", $_config->activeModules))); //el array_filter elimina los indices del array con espacios vacios o nulos y el array_values reordena los ids del array para que no queden ids vacios que se han borrado con el array_filter

// MULTIIDIOMA
//Creamos variable de sesión con el lenguaje
if(!isset($_COOKIE['lang'])) $_COOKIE['lang'] = 'es';
if(isset($_GET['lang'])) $_COOKIE['lang'] = $_GET['lang'];
//include_once("lang/lang_es.php");
$LANG = array();
// BD
actualizarTerminosIdioma();
// BD
//Creamos variable de sesión con el lenguaje
// MULTIIDIOMA

include_once ("loadSettings.php");


if(isset($_GET['logout'])){
	unset($_SESSION['usuario']);
    header("Location: " . $settings_urlbase);
}
?>