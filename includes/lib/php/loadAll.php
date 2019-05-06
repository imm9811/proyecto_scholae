<?php
session_start();
if(isset($_GET['exit'])){
	unset($_SESSION);
	session_destroy();
	session_start();
}
//ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('Europe/Madrid');
setlocale(LC_ALL, "es_ES"); //idioma de los date() en español
ini_set('default_charset', 'utf-8');

/*
//Creamos variable de sesión con el lenguaje
$lenguas_permitidas=array('es','en'); //listado de lenguajes a usar
if(isset($_REQUEST['lang'])){
	//se recibimos un lenguaje lo ponemos en sesion, en minusculas y sin espacios y sin ningun caracter que no sea numero o letra
	$_SESSION['lang'] = strtolower(trim(preg_replace('([^A-Za-z0-9])', '', $_REQUEST['lang'])));
	if(!in_array($_SESSION['lang'], $lenguas_permitidas) || $_SESSION['lang']=='es'){
		$_SESSION['lang'] = ''; //si no es un lenguaje permitido o si es español, lo dejamos a vacio
	}	
}else{
	$_SESSION['lang'] = ''; //si no enviamos lenguaje, lo dejamos a vacio
}

//En funcion al lenguaje recibido cargamos fichero de idiomas
if($_SESSION['lang'] == '')	include_once("lang/lang_es.php");
else include_once("lang/lang_".$_SESSION['lang'].".php");
 */
//Cargamos resto de librerias php
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
		header('Location: content');
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
$_config->activeModules = array_values(array_filter(explode(";", $_config->activeModules))); //el array_filter elimina los indices del array con espacios vacios o nulos y el array_values reordena los ids del array para que no queden ids vacios que se han borrado con el array_filter
