<?php

//comprueba permisos por el id y el modulo
function tienePermisos($modulo, $id){
	$puede=false;
	$usuario=Doctrine_Core::getTable('User')->find($id);
	if($usuario->type == 0 )$puede=true;
	if($usuario->type == 1 && $modulo->isActive == 1)$puede=true;
	if($usuario->type == 10 && ($modulo->link == 'content' || $modulo->link == 'events'))$puede=true;
	
	return $puede;
}

//categorias recursivas devueltas en options
function listadoRecursivoOptions($tabla, $selected=null, $actual=null, $campoId='id', $campoName='title', $campoParent='parentId', $padre='null', $espacios=''){
	$txtPadre=(is_numeric($padre))?' = '.$padre:' is null';
	$listado = Doctrine_Query::create()->from($tabla)->where($campoParent.$txtPadre)->execute();
	if(count($listado) > 0){
		foreach($listado as $l){
			if($actual != $l->$campoId){
				echo '<option value="'.$l->$campoId.'" '.($selected==$l->$campoId ?'SELECTED':'').'>'.$espacios.$l->$campoName.'</option>';
			}
			listadoRecursivoOptions($tabla, $selected, $actual, $campoId, $campoName, $campoParent, $l->$campoId, $espacios.'&nbsp;&nbsp;&nbsp;');
		}		
	}
}

//categorias recursivas devueltas en options
function listadoRecursivoLi($tabla, $selected=null, $actual=null, $campoId='id', $campoName='title', $campoParent='parentId', $padre='null', $espacios='', $clasePrimero='', $clasePadreNull='', $idPrimero=''){
	$txtPadre=(is_numeric($padre))?' = '.$padre:' is null';
	$listado = Doctrine_Query::create()->from($tabla)->where($campoParent.$txtPadre)->orderBy('position')->execute();
	if(count($listado) > 0){
		echo '<ul class="'.$clasePrimero.'" id="'.$idPrimero.'">';
		$clasePrimero='';
		$idPrimero='';
		foreach($listado as $l){
			echo '<li '.($selected==$l->$campoId ?'class="current"':'').'><a href="'.((isset($l->alternativeLink) && $l->alternativeLink!='' && $l->alternativeLink != null)?$l->alternativeLink:'contenido-'.$l->urlFriendly).'" '.($padre=='null' ?'class="'.'isMenuItem'.'"':'').'>'.$l->$campoName.'</a>';
			listadoRecursivoLi($tabla, $selected, $actual, $campoId, $campoName, $campoParent, $l->$campoId, $espacios,$clasePrimero,$clasePadreNull);
			echo '</li>';
		}		
		echo '</ul>';
	}
}

//Función para convertir BYTES a su correspondiente legible
function format_bytes($tamano, $decimales=2, $separador_decimal=',', $separador_miles='.'){
    $unidades = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

    for($i=0, $len=count($unidades)-1; $i<$len && $tamano>=1024; $i++){
        $tamano /= 1024;
    }

    $tamano = round($tamano, $decimales);
    $decimales = ((int)$tamano==$tamano) ? 0 : $decimales; // Si es entero no mostramos decimales

    return number_format($tamano, $decimales, $separador_decimal, $separador_miles) . ' ' . $unidades[$i];
}

//Función para quitar caracteres extraños (UrlFriend)
function UrlFriend($str) {
	$str=strip_tags($str);
    $search = array('&lt;', '&gt;', '&quot;', '&amp;');
    $str = str_replace($search, '', $str);
    $search = array('&aacute;', '&Aacute;', '&eacute;', '&Eacute;', '&iacute;', '&Iacute;', '&oacute;', '&Oacute;', '&uacute;', '&Uacute;', '&ntilde;', '&Ntilde;');
    $replace = array('a', 'a', 'e', 'e', 'i', 'i', 'o', 'o', 'u', 'u', 'n', 'n');
    $search = array('Á', 'É', 'Í', 'Ó', 'Ú', 'á', 'é', 'í', 'ó', 'ú', 'Ü', 'ü', 'Ñ', 'ñ', '_', '-');
    $replace = array('a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'u', 'u', 'n', 'n', ' ', ' ');
    $str = str_replace($search, $replace, $str);

    $str = preg_replace('/&(?!#[0-9]+;)/s', '', $str);
    //$search = array(' a ', ' ante ', ' de ', ' para ', ' con ', ' contra ', ' por ', ' entre ', ' en ', ' sobre ', ' bajo ', ' y ', ' e ', ' o ', ' u ', ' este ', 'aquel ', ' la ', ' el ', ' lo ', ' las ', ' los ');
    //$str = str_replace($search, ' ', strtolower($str));
    //$str = str_replace($search, $replace, strtolower(trim($str)));
	$str = strtolower(trim($str));
    $str = preg_replace("/[^a-zA-Z0-9\s]/", '', $str);
    $str = preg_replace('/\s\s+/', ' ', $str);
    $str = str_replace(' ', '-', $str);

    return $str;
}

function urlFromTitle($title, $nombreTabla, $id=null, $campoFriend='urlfriend')
{
	$urlFriend=UrlFriend($title);
	$cont=null;
	do {
		$sigue=true;
		$urlTemp=$urlFriend.$cont;
		
		// COMPROBAR EXISTENCIA
		$existe=Doctrine_Query::create()->from($nombreTabla)->where($campoFriend.' = ?', $urlTemp);
		if($id!=null)$existe = $existe->andWhere('id != ?', $id);
		$existe = $existe->limit(1)->execute()->getFirst();
		// COMPROBAR EXISTENCIA - FIN
		
		if(!$existe){
			$sigue=false;
			$urlFriend=$urlTemp;
		}else{
			$cont++;
		}
	}while($sigue==true);
	return $urlFriend;
}

function limpiarURL($str) {
    //Quitar tildes y ñ
    $tildes = array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ');
    $vocales = array('a', 'e', 'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N');
    $str = str_replace($tildes, $vocales, $str);

    //Quitar símbolos
    $simbolos = array("¿", "¡", "!", "'", "%", "€", "(", ")", "[", "]", "{", "}", "*", "+", "·", "&lt; ", "&gt;");
    $i = 0;
    while ($simbolos[$i]) {
        $str = str_replace($simbolos[$i], "", $str);
        $i++;
    }

    //Quitar espacios
    $str = str_replace(" ", "_", $str);

    //Pasar a minúsculas
    $str = strtolower($str);

    return $str;
}

//Función convertir fecha a Mysql para las busquedas
function convert_to_mysql($fecha) {
    ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
    $lafecha = $mifecha[3] . "-" . $mifecha[2] . "-" . $mifecha[1];
    return $lafecha;
}

//Función para convertir las fechas de mysql a Español
function convert_from_mysql($fecha) {
    ereg("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
    return $lafecha;
}

//Función para cortar en un nº determinado de palabras
function cut_letters($text, $show_letters) {
    $cadena_a_separar = $text;
    $matriz_llegada = explode(" ", $cadena_a_separar);
    $num_palabras = $show_letters; // el numero de palabras a imprimir
//comprubo que el numero de palabras no es menor al que se tiene

    if (count($matriz_llegada) < $show_letters)
        $num_palabras = count($matriz_llegada);

    for ($i = 0; $i < $num_palabras; $i++)
        $mostrar = $mostrar . $matriz_llegada[$i] . " ";

    return $mostrar . " ...";
}

//Genera una cadena aleatoria
function cadena_aleatoria($numero) {
    $caracter = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    srand((double) microtime() * 1000000);
    for ($i = 0; $i < $numero; $i++) {
        $rand.= $caracter[rand() % strlen($caracter)];
    }
    return $rand;
}

//Generador de contraseñas.
function generaPass(){
	//Se define una cadena de caractares. Te recomiendo que uses esta.
	$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	//Obtenemos la longitud de la cadena de caracteres
	$longitudCadena=strlen($cadena);
 
	//Se define la variable que va a contener la contraseña
	$pass = "";
	//Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
	$longitudPass=10;
 
	//Creamos la contraseña
	for($i=1 ; $i<=$longitudPass ; $i++){
		//Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
		$pos=rand(6,$longitudCadena-1);
 
		//Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
		$pass .= substr($cadena,$pos,1);
	}
return $pass;
}
?>