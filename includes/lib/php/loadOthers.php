<?php
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
    $str = str_replace('ç', 'c', $str);
    $str = str_replace('ł', 'l', $str);
    $str = str_replace('ć', 'c', $str);
    $str = str_replace('å', 'a', $str);
    $str = str_replace('õ', 'o', $str);

    $search = array('&lt;', '&gt;', '&quot;', '&amp;');
    $str = str_replace($search, '', $str);
    $search = array('&aacute;', '&Aacute;', '&eacute;', '&Eacute;', '&iacute;', '&Iacute;', '&oacute;', '&Oacute;', '&uacute;', '&Uacute;', '&ntilde;', '&Ntilde;');
    $replace = array('a', 'a', 'e', 'e', 'i', 'i', 'o', 'o', 'u', 'u', 'n', 'n');
    $search = array('Á', 'É', 'Í', 'Ó', 'Ú', 'á', 'é', 'í', 'ó', 'ú', 'Ü', 'ü', 'Ñ', 'ñ', '_', '-', 'à', 'è', 'ì', 'ò', 'ù');
    $replace = array('a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'u', 'u', 'n', 'n', ' ', ' ', 'a', 'e', 'i', 'o', 'u');
    $str = str_replace($search, $replace, $str);

    $str = preg_replace('/&(?!#[0-9]+;)/s', '', $str);
    $search = array(' a ', ' ante ', ' de ', ' para ', ' con ', ' contra ', ' por ', ' entre ', ' en ', ' sobre ', ' bajo ', ' y ', ' e ', ' o ', ' u ', ' este ', 'aquel ', ' la ', ' el ', ' lo ', ' las ', ' los ');
    $str = str_replace($search, ' ', strtolower($str));
    $str = str_replace($search, $replace, strtolower(trim($str)));

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
		//$existe=Doctrine_Core::getTable($nombreTabla)->findOneByUrlFriendly($urlTemp);
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

// ADDED
// Permite dibujar un select html parametrizando esta función
function drawSelect($tabla, $campo_option="id", $campo_seleccion="id", $seleccion_valor, $option_label, $where="", $orderBy="", $leftjoin="", $tablaOptionLabel=null, $includeCount=false, $countTable=null, $countFieldTable=null)
{
    $selector_tabla = $tabla;
    $selector_where = $where;
    $selector_leftjoin = $leftjoin;
    $selector_campo_option = $campo_option;
    $selector_campo_seleccion = $campo_seleccion;
    $selector_seleccion_valor = $seleccion_valor;
    $selector_orderBy = $orderBy;

    $registros=Doctrine_Query::create()->from($selector_tabla);
    if($selector_leftjoin != "") $registros = $registros->leftJoin($selector_leftjoin);
    if($selector_where != "") $registros = $registros->where($selector_where);
    if($selector_orderBy != "") $registros = $registros->orderBy($selector_orderBy);
    $registros = $registros->execute();

    foreach($registros as $registro)
    {
        if($includeCount)
        {
            if(!is_array($countFieldTable)) $count = Doctrine_Query::create()->select('count(*) as cont')->from($countTable)->where($countFieldTable . ' = ' . $registro->id)->execute()->getFirst();
            else
            {
                $countFieldWhere = "";
                foreach($countFieldTable as $countField)
                {
                    $countFieldWhere .= ($countField . ' = ' . $registro->id . ' OR ');
                }
                $countFieldWhere = substr($countFieldWhere, 0, -3);

                if(!empty($countFieldWhere)) $count = Doctrine_Query::create()->select('count(*) as cont')->from($countTable)->where($countFieldWhere)->execute()->getFirst();
            }
        }

        if(is_array($option_label))
        {
            $selector_option_label = "";
            foreach($option_label as $option)
            {
                $selector_option_label .= $registro->{$option} . ' ';
            }
            $selector_option_label = substr($selector_option_label, 0, -1);
        }
        else
            $selector_option_label = $registro->{$option_label};

    	echo '<option value="'.$registro->{$selector_campo_option}.'" '. (in_array($registro->{$selector_campo_seleccion}, (is_array($selector_seleccion_valor)?$selector_seleccion_valor:array()))  ? 'selected':'') .'>&nbsp;'.$selector_option_label . ' '. ($includeCount?'(' .$count->cont . ')':'').'</option>';
    }
}

function drawSelectMultiidioma($tabla, $defaultLang, $campo_option="id", $campo_seleccion="id", $seleccion_valor, $option_label, $where="", $orderBy="", $leftjoin="", $tablaOptionLabel=null, $includeCount=false, $countTable=null, $countFieldTable=null)
{
    $selector_tabla = $tabla;
    $selector_where = $where;
    $selector_leftjoin = $leftjoin;
    $selector_campo_option = $campo_option;
    $selector_campo_seleccion = $campo_seleccion;
    $selector_seleccion_valor = $seleccion_valor;
    $selector_orderBy = $orderBy;

    $registros=Doctrine_Query::create()->from($selector_tabla);
    if($selector_leftjoin != "") $registros = $registros->leftJoin($selector_leftjoin);
    if($selector_where != "") $registros = $registros->where($selector_where);
    if($selector_orderBy != "") $registros = $registros->orderBy($selector_orderBy);
    $registros = $registros->execute();

    foreach($registros as $registro)
    {
        // CONTEMPLAR INFO EXTRA DEL OBJETO
        if(!empty($tablaOptionLabel))
        {
            if(is_array($tablaOptionLabel))
            {
                $selector_option_label = "";
                foreach($tablaOptionLabel as $option)
                {
                    $selector_option_label .= $registro->{$option} . ' ';
                }
                $selector_option_label = substr($selector_option_label, 0, -1);
            }
            else
                $selector_option_label = $registro->{$tablaOptionLabel};
        }
        // CONTEMPLAR INFO EXTRA DEL OBJETO

        if($includeCount)
        {
            if(!is_array($countFieldTable)) $count = Doctrine_Query::create()->select('count(*) as cont')->from($countTable)->where($countFieldTable . ' = ' . $registro->id)->execute()->getFirst();
            else
            {
                $countFieldWhere = "";
                foreach($countFieldTable as $countField)
                {
                    $countFieldWhere .= ($countField . ' = ' . $registro->id . ' OR ');
                }
                $countFieldWhere = substr($countFieldWhere, 0, -3);

                if(!empty($countFieldWhere)) $count = Doctrine_Query::create()->select('count(*) as cont')->from($countTable)->where($countFieldWhere)->execute()->getFirst();
            }
        }

        $translation = Doctrine_Query::create()->select('term, translation, isocode')
                                    ->from('Translation')
                                    ->where('tableName = ?', $selector_tabla)
                                    ->andWhere('term = ?', UrlFriend($selector_tabla).'-'.UrlFriend($option_label))
                                    ->andWhere('isocode = ?', $defaultLang)
                                    ->andWhere('token = ?', $registro->token)
                                    ->orderBy('isocode ASC')
                                    ->execute()
                                    ->getFirst();
    	echo '<option value="'.$registro->{$selector_campo_option}.'" '. (in_array($registro->{$selector_campo_seleccion}, $selector_seleccion_valor)  ? 'selected':'') .'>&nbsp;'.$selector_option_label . ' ' . $translation->translation  . ' ' . ($includeCount?'(' .$count->cont . ')':'')  .'</option>';
    }
}

// MULTIIDIOMA
// Muestra el selector de idioma común a todos los campos
// Posibilidad de invocar un callback para procesar cambios como en noticias
function loadLanguageSelector($callbacks="")
{
    $defaultLang = Doctrine_Core::getTable('Configs')->findOneByParam('defaultLang');
    $idiomasTerminos = Doctrine_Query::create()->from('Language')->where('isActive = ?', 1)->orderBy('isocode ASC')->execute();

    // SELECT
    $html .= '
    <div class="uk-width-medium parsley-row">
    <h3 style="display: inline-block">Idioma campos multiidioma</h3>

    <select class="seleccion-idioma" id="languageSelector" onchange="cambiarIdioma(this.value)'.(!empty($callbacks)?';'.$callbacks:'').'">';

    $idioma=0;
    foreach($idiomasTerminos as $idiomaTermino)
    {
        $html .= '<option value="'. $idioma .'" '.($idiomaTermino->isocode == $defaultLang->value ? 'selected' : '').'>'. $idiomaTermino->title .'</option>';
        $idioma++;
    }

    $html .= '
    </select>
    </div>';

    echo $html;
}


// Cargar un input multiidioma
// Depende del save en cargas.php
function loadLanguageTerm($tableName, $token, $field, $inputType="text", $gridCols="uk-width-medium", $required=false, $alternativeTitle="")
{
    $defaultLang = Doctrine_Core::getTable('Configs')->findOneByParam('defaultLang');
    $idiomasTerminos = Doctrine_Query::create()->from('Language')->where('isActive = ?', 1)->orderBy('isocode ASC')->execute();
    $termName = UrlFriend($tableName).'-'.UrlFriend($field);

    $idioma=0;
    foreach($idiomasTerminos as $idiomaTermino)
    {
        $termino_info = Doctrine_Query::create()->from('Translation')
                                                ->where('tableName = ?', $tableName)
                                                ->andWhere('token = ?', $token)
                                                ->andWhere('term = ?', $termName)
                                                ->andWhere('isocode = ?', $idiomaTermino->isocode)
                                                ->orderBy('isocode ASC')->execute()->getFirst();
        $html .= '
        <div class="'.$gridCols.' parsley-row idiomas idioma-'. $idioma .'" style="'.($idiomaTermino->isocode == $defaultLang->value ? 'display: block' : 'display: none').'">';
            switch($inputType)
            {
                case 'hidden':
                    $html .= '
                    <div class="col-md-12">
                        <input type="hidden" name="'.$termName.'['.$idioma.']" value="'.($termino_info->translation?str_replace("<br />", "\r\n", $termino_info->translation):' ').'" id="wizard_title" '.($required?'required':'').' class="md-input" placeholder="'.$idiomaTermino->title.'">
                    </div>';

                break;
                case 'text':
                    $html .= '
                    <label for="wizard_title">'.($alternativeTitle?$alternativeTitle:$field).'</label>
                    <div class="col-md-12">
                        <input type="text" name="'.$termName.'['.$idioma.']" value="'.str_replace("<br />", "\r\n", $termino_info->translation).'" id="wizard_title" '.($required?'required':'').' class="md-input" placeholder="'.$idiomaTermino->title.'">
                    </div>';
                break;
                case 'textarea':
                    $html .= '
                    <label for="wizard_title">'.($alternativeTitle?$alternativeTitle:$field).'</label>
                    <div class="col-md-12">
                        <textarea cols="30" rows="4" '.($required?'required':'').' class="md-input" name="'.$termName.'['.$idioma.']" placeholder="'.$idiomaTermino->title.'">'.str_replace("<br />", "\r\n", $termino_info->translation).'</textarea>
                    </div>';
                break;
            }
        $html .= '
        </div>';
        $idioma++;
    }

    echo $html;
}

// Cargar contenido del editor avanzado a partir del idioma elegido
function loadLanguageContent($tableName, $token, $field, $langIsocode)
{
    $idiomaTermino = Doctrine_Core::getTable('Language')->findOneByIsocode($langIsocode);
    $termName = UrlFriend($tableName).'-'.UrlFriend($field);

    $termino_info = Doctrine_Query::create()->from('Translation')
                                            ->where('tableName = ?', $tableName)
                                            ->andWhere('token = ?', $token)
                                            ->andWhere('term = ?', $termName)
                                            ->andWhere('isocode = ?', $langIsocode)
                                            ->orderBy('isocode ASC')->execute()->getFirst();


    echo $termino_info->translation;
}

function getTranslatedField($tableName, $token, $field, $isocode)
{
    $reg = Doctrine_Query::create()->select('term, translation, isocode')
                                    ->from('Translation')
                                    ->where('tableName = ?', $tableName)
                                    ->andWhere('token = ?', $token)
                                    ->andWhere('term = ?', UrlFriend($tableName).'-'.UrlFriend($field))
                                    ->andWhere('isocode = ?', $isocode)
                                    ->orderBy('isocode ASC')
                                    ->execute()
                                    ->getFirst();
    return $reg->translation;
}

// Obtener traducción de un término de idiomas
function getTranslatedTerm($term, $isocode)
{
    $reg = Doctrine_Query::create()->select('term, translation, isocode')
                                    ->from('Translation')
                                    ->andWhere('term = ?', $term)
                                    ->andWhere('isocode = ?', $isocode)
                                    ->orderBy('isocode ASC')
                                    ->execute()
                                    ->getFirst();
    return $reg->translation;
}

// Obtener objeto de una clase a partir del campo urlfriend
// Depende de un término multiidioma 'urlfriend'
function getObjByUrlFriend($tableName, $isocode, $urlfriend, $updateLangTerms=true)
{
    $translation = Doctrine_Query::create()->select('term, translation, isocode')
                                    ->from('Translation')
                                    ->where('tableName = ?', $tableName)
                                    ->andWhere('term = ?', UrlFriend($tableName).'-'.UrlFriend('urlfriend'))
                                    //->andWhere('isocode = ?', $isocode)
                                    ->andWhere('translation = ?', $urlfriend)
                                    ->orderBy('isocode ASC')
                                    ->execute()
                                    ->getFirst();
    if($translation)
    {
        if($updateLangTerms && $translation->isocode != $_COOKIE['lang'])
        {
            $_COOKIE['lang'] = $translation->isocode;
            actualizarTerminosIdioma();
        }

        $reg = Doctrine_Query::create()->from($tableName)
                                    ->where('token = ?', $translation->token)
                                    ->execute()
                                    ->getFirst();
        return $reg;
    }
    else return null;
}


// Obtener el urlfriend de un objeto en otro idioma
function getLangUrlFriend($object, $isocode=null)
{
    if($object)
    {
        $tableName = get_class($object);
        $token = $object->token;

        // Entre 2 idiomas
        if(!$isocode) $isocode = ($_COOKIE['lang'] == 'es' ? 'en':'es');

        $translation = Doctrine_Query::create()->select('term, translation, isocode')
                                        ->from('Translation')
                                        ->where('tableName = ?', $tableName)
                                        ->andWhere('term = ?', UrlFriend($tableName).'-'.UrlFriend('urlfriend'))
                                        ->andWhere('token = ?', $token)
                                        ->andWhere('isocode = ?', $isocode)
                                        ->execute()
                                        ->getFirst();
        /*
        if($isocode != $_COOKIE['lang'])
        {
            $_COOKIE['lang'] = $isocode;
            actualizarTerminosIdioma();
        }
        */

        return $translation->translation;
    }
    else return null;
}

function getLangModuleUrlFriend($moduleObj, $isocode=null, $listado=true)
{

    if($moduleObj)
    {
        $token = $moduleObj->token;

        // Entre 2 idiomas
        if(!$isocode) $isocode = ($_COOKIE['lang'] == 'es' ? 'en':'es');

        $translation = Doctrine_Query::create()->select('term, translation, isocode')
                                        ->from('Translation')
                                        ->where('tableName = ?', 'Module')
                                        ->andWhere('term = ?', 'module-'.($listado?'urlfriend-listado':'urlfriend'))
                                        ->andWhere('token = ?', $token)
                                        ->andWhere('isocode = ?', $isocode)
                                        ->execute()
                                        ->getFirst();
        return $translation->translation;
    }
    else return null;
}

// Actualizar termino 'urlfriend' del objeto con el valor del termino '$urlFriendField'
function updateObjUrlFriend($object, $urlFriendField, $appendBefore="", $appendAfter="")
{
    $tableName = get_class($object);
    $token = $object->token;

    // Recorrer idiomas
    $idiomasTerminos = Doctrine_Query::create()->from('Language')->where('isActive = ?', 1)->orderBy('isocode ASC')->execute();
    foreach($idiomasTerminos as $idioma)
    {
        // se usa un solo campo: titulo
        if(!is_array($urlFriendField))
        {
            $urlfriend = Doctrine_Query::create()->select('translation')
                            ->from('Translation')
                            ->where('tableName = ?', $tableName)
                            ->andWhere('token = ?', $token)
                            ->andWhere('term = ?', UrlFriend($tableName).'-'.UrlFriend($urlFriendField))
                            ->andWhere('isocode = ?', $idioma->isocode)
                            ->execute()
                            ->getFirst();

            // Crear urlfriend a partir de urlFriendField
            if($urlfriend)
            {
                $campoUrlFriendTranslation = UrlFriend($tableName).'-'.UrlFriend('urlfriend');
                $reg = Doctrine_Query::create()->select('translation')
                            ->from('Translation')
                            ->where('tableName = ?', $tableName)
                            ->andWhere('token = ?', $token)
                            ->andWhere('term = ?', $campoUrlFriendTranslation)
                            ->andWhere('isocode = ?', $idioma->isocode)
                            ->execute()
                            ->getFirst();

                $reg->translation = UrlFriend($appendBefore.$urlfriend->translation.$appendAfter);
                $reg->trySave();
            }
        }
        else
        { // Concatenar varios con guiones
            $urlfriendFinal = "";
            foreach($urlFriendField as $urlFriendField)
            {
                $urlfriend = Doctrine_Query::create()->select('translation')
                                    ->from('Translation')
                                    ->where('tableName = ?', $tableName)
                                    ->andWhere('token = ?', $token)
                                    ->andWhere('term = ?', UrlFriend($tableName).'-'.UrlFriend($urlFriendField))
                                    ->andWhere('isocode = ?', $idioma->isocode)
                                    ->execute()
                                    ->getFirst();

                if($urlfriend) $urlfriendFinal .= '-'.$urlfriend->translation;


            }

            // Crear urlfriend a partir de urlFriendField
            $urlfriendFinal = substr($urlfriendFinal, 1);
            if($urlfriendFinal)
            {
                $campoUrlFriendTranslation = UrlFriend($tableName).'-'.UrlFriend('urlfriend');
                $reg = Doctrine_Query::create()->select('translation')
                            ->from('Translation')
                            ->where('tableName = ?', $tableName)
                            ->andWhere('token = ?', $token)
                            ->andWhere('term = ?', $campoUrlFriendTranslation)
                            ->andWhere('isocode = ?', $idioma->isocode)
                            ->execute()
                            ->getFirst();

                $reg->translation = UrlFriend($appendBefore.$urlfriendFinal.$appendAfter);
                $reg->trySave();
            }
        }
    }
}

// Actualiza el termino urlfriend en funcion de un array de objetos relacionados (objeto => termino)
function updateObjUrlFriendRelatedObjects($object, $arrayRelatedObjects, $arrayRelatedFields)
{
    $tableName = get_class($object);
    $token = $object->token;

    // Recorrer idiomas
    $idiomasTerminos = Doctrine_Query::create()->from('Language')->where('isActive = ?', 1)->orderBy('isocode ASC')->execute();
    foreach($idiomasTerminos as $idioma)
    {
        $urlfriendFinal = "";
        for($i=0; $i<count($arrayRelatedObjects); $i++)
        {
            $tableNameRelated = get_class($arrayRelatedObjects[$i]);
            $tokenRelated = $arrayRelatedObjects[$i]->token;

            $urlfriend = Doctrine_Query::create()->select('translation')
                                ->from('Translation')
                                ->where('tableName = ?', $tableNameRelated)
                                ->andWhere('token = ?', $tokenRelated)
                                ->andWhere('term = ?', UrlFriend($tableNameRelated).'-'.UrlFriend($arrayRelatedFields[$i]))
                                ->andWhere('isocode = ?', $idioma->isocode)
                                ->execute()
                                ->getFirst();

            if($urlfriend) $urlfriendFinal .= '-'.$urlfriend->translation;


        }

        // Crear urlfriend a partir de urlFriendField
        $urlfriendFinal = substr($urlfriendFinal, 1);
        if(!empty($urlfriendFinal))
        {
            $campoUrlFriendTranslation = UrlFriend($tableName).'-'.UrlFriend('urlfriend');
            $reg = Doctrine_Query::create()->select('translation')
                        ->from('Translation')
                        ->where('tableName = ?', $tableName)
                        ->andWhere('token = ?', $token)
                        ->andWhere('term = ?', $campoUrlFriendTranslation)
                        ->andWhere('isocode = ?', $idioma->isocode)
                        ->execute()
                        ->getFirst();

            $reg->translation = UrlFriend($urlfriendFinal);
            $reg->trySave();
        }
    }
}


// Actualiza el termino urlfriend en funcion de una cadena de texto en cada idioma
/*
    $arrayLangText = array('es' => 'Hola mundo', 'en' => 'Hello World')
*/
function updateObjUrlFriendLangText($object, $arrayLangText)
{
    $tableName = get_class($object);
    $token = $object->token;

    // Recorrer idiomas
    $idiomasTerminos = Doctrine_Query::create()->from('Language')->where('isActive = ?', 1)->orderBy('isocode ASC')->execute();
    foreach($idiomasTerminos as $idioma)
    {
        // Crear urlfriend a partir de urlFriendField
        $urlfriendFinal = $arrayLangText[$idioma->isocode];
        if(!empty($urlfriendFinal))
        {
            $campoUrlFriendTranslation = UrlFriend($tableName).'-'.UrlFriend('urlfriend');
            $reg = Doctrine_Query::create()->select('translation')
                        ->from('Translation')
                        ->where('tableName = ?', $tableName)
                        ->andWhere('token = ?', $token)
                        ->andWhere('term = ?', $campoUrlFriendTranslation)
                        ->andWhere('isocode = ?', $idioma->isocode)
                        ->execute()
                        ->getFirst();

            if(!empty($urlfriendFinal))$reg->translation = UrlFriend($urlfriendFinal);
            $reg->trySave();
        }
    }
}

// Actualiza el termino urlfriend en funcion de una cadena de texto para todos los idiomas
function updateObjUrlFriendText($object, $text)
{
    $tableName = get_class($object);
    $token = $object->token;

    // Recorrer idiomas
    $idiomasTerminos = Doctrine_Query::create()->from('Language')->where('isActive = ?', 1)->orderBy('isocode ASC')->execute();
    foreach($idiomasTerminos as $idioma)
    {
        // Crear urlfriend a partir de urlFriendField
        $urlfriendFinal = $text;
        if(!empty($urlfriendFinal))
        {
            $campoUrlFriendTranslation = UrlFriend($tableName).'-'.UrlFriend('urlfriend');
            $reg = Doctrine_Query::create()->select('translation')
                        ->from('Translation')
                        ->where('tableName = ?', $tableName)
                        ->andWhere('token = ?', $token)
                        ->andWhere('term = ?', $campoUrlFriendTranslation)
                        ->andWhere('isocode = ?', $idioma->isocode)
                        ->execute()
                        ->getFirst();

            if(!empty($urlfriendFinal))$reg->translation = UrlFriend($urlfriendFinal);
            $reg->trySave();
        }
    }
}

// Actualizar termino de idiomas de un objeto para un idioma en concreto
function updateObjTermLang($object, $urlFriendField, $value, $isocode)
{
    $tableName = get_class($object);
    $token = $object->token;

    // Recorrer idiomas
    $urlfriend = Doctrine_Query::create()->select('translation')
                        ->from('Translation')
                        ->where('tableName = ?', $tableName)
                        ->andWhere('token = ?', $token)
                        ->andWhere('term = ?', UrlFriend($urlFriendField))
                        ->andWhere('isocode = ?', $isocode)
                        ->execute()
                        ->getFirst();

    $urlfriend->translation = $value;
    try
    {
        $urlfriend->save();
    }
    catch(Exception $e)
    {
        error_log($e);
        return false;
    }
    return true;
}

// Actualizar termino de idiomas de un objeto para todos los idiomas
function updateObjTermAllLangs($object, $urlFriendField, $value)
{
    $tableName = get_class($object);
    $token = $object->token;

    // Recorrer idiomas
    $idiomasTerminos = Doctrine_Query::create()->from('Language')->where('isActive = ?', 1)->orderBy('isocode ASC')->execute();
    foreach($idiomasTerminos as $idioma)
    {
        $urlfriend = Doctrine_Query::create()->select('translation')
                                            ->from('Translation')
                                            ->where('tableName = ?', $tableName)
                                            ->andWhere('token = ?', $token)
                                            ->andWhere('term = ?', UrlFriend($urlFriendField))
                                            ->andWhere('isocode = ?', $idioma->isocode)
                                            ->execute()
                                            ->getFirst();

        if($urlfriend)
        {
            $urlfriend->translation = $value;
            try
            {
                $urlfriend->save();
            }
            catch(Exception $e)
            {
                error_log($e);
                return false;
            }
        }
    }
    return true;
}

// Actualizar termino de idiomas de un objeto para todos los idiomas
function createObjTermAllLangs($object, $urlFriendField, $value)
{
    $tableName = get_class($object);
    $token = $object->token;

    // Recorrer idiomas
    $idiomasTerminos = Doctrine_Query::create()->from('Language')->where('isActive = ?', 1)->orderBy('isocode ASC')->execute();
    foreach($idiomasTerminos as $idioma)
    {
        $urlfriend = new Translation();
        $urlfriend->tableName = $tableName;
        $urlfriend->token = $token;
        $urlfriend->field = UrlFriend($tableName).'-'.UrlFriend($urlFriendField);
        $urlfriend->term = UrlFriend($tableName).'-'.UrlFriend($urlFriendField);
        $urlfriend->isocode = $idioma->isocode;
        $urlfriend->translation = $value;

        try
        {
            $urlfriend->save();
        }
        catch(Exception $e)
        {
            error_log($e);
            return false;
        }
    }
    return true;
}


// Obtener un solo campo multiidioma
function getTranslatedObjectField($object, $field, $isocode)
{
    $tableName = get_class($object);
    $token = $object->token;

    $reg = Doctrine_Query::create()->select('term, translation, isocode')
                                    ->from('Translation')
                                    ->where('tableName = ?', $tableName)
                                    ->andWhere('token = ?', $token)
                                    ->andWhere('term = ?', UrlFriend($tableName).'-'.UrlFriend($field))
                                    ->andWhere('isocode = ?', $isocode)
                                    ->orderBy('isocode ASC')
                                    ->execute()
                                    ->getFirst();
    return $reg->translation;
}

// Devolver objeto con todos los campos multiidioma. $obj_fields['titulo']
function getTranslatedFields($object, $isocode)
{
    $tableName = get_class($object);
    $token = $object->token;

    $traducciones = Doctrine_Query::create()->select('term, translation, isocode')
                                    ->from('Translation')
                                    ->where('tableName = ?', $tableName)
                                    ->andWhere('token = ?', $token)
                                    ->andWhere('isocode = ?', $isocode)
                                    ->orderBy('term ASC')
                                    ->execute();
    $traduccionesObj = new stdClass();
    foreach($traducciones as $traduccion)
    {
        $traduccionesObj->{str_replace(UrlFriend($tableName) . '-' ,'', $traduccion->term)} = $traduccion->translation;
    }
    return $traduccionesObj;
}

// Devolver objeto con todos los campos multiidioma. $obj_fields['titulo']
function getTranslatedFieldsByTableName($object, $tableName, $isocode)
{
    $token = $object->token;
    $traducciones = Doctrine_Query::create()->select('term, translation, isocode')
                                    ->from('Translation')
                                    ->where('tableName = ?', $tableName)
                                    ->andWhere('token = ?', $token)
                                    ->andWhere('isocode = ?', $isocode)
                                    ->orderBy('term ASC')
                                    ->execute();
    $traduccionesObj = new stdClass();
    foreach($traducciones as $traduccion)
    {
        $traduccionesObj->{str_replace(UrlFriend($tableName) . '-' ,'', $traduccion->term)} = $traduccion->translation;
    }
    return $traduccionesObj;
}

// Guarda los contenidos
// Debe ser preparado en cuanto a variables entorno como noticias
function saveLanguageContent($tableName, $token)
{
    $selectedIndex = $_POST['langMaquetacion'];
    $idiomasTerminos = Doctrine_Query::create()->from('Language')->where('isActive = ?', 1)->orderBy('isocode ASC')->execute();
    $idiomaSeleccionado = $idiomasTerminos[$selectedIndex];
    $termName = UrlFriend($tableName).'-'.UrlFriend('content');

    $terminoBD = Doctrine_Query::create()->from('Translation')
                                        ->where('tableName = ?', $tableName)
                                        ->andWhere('token = ?', $token)
                                        ->andWhere('term = ?', stripslashes($termName))
                                        ->andWhere('isocode = ?', $idiomaSeleccionado->isocode)
                                        ->limit(1)->execute()->getFirst();
    if(!$terminoBD)
    {
        $terminoBD = new Translation();
    }
    $terminoBD->isocode = $idiomaSeleccionado->isocode;
    $terminoBD->term = $termName;
    $terminoBD->tableName = $tableName;
    $terminoBD->field = $termName;
    $terminoBD->token = $token;
    if($terminoBD->translation != $_POST['maquetacion'])
    {
        Doctrine_Query::create()->update('Translation')->set('updatedAt', 'NOW()')->where('term = ?', $termName)->execute();
    }
    $terminoBD->translation = $_POST['maquetacion'];
    try
    {
        $terminoBD->save();
        return true;
    }catch(Exception $e){
        return false;
        error_log('Error: ' . __FILE__ . ' linea ' . __LINE__ . $e);
    }
}


// Guarda los términos
// Importante: Procesar variables POST que sean arrays previamente y usar unset cuando se finalice para que no sea procesado por el sistema multiidioma
function saveLanguageTerms($tableName, $token)
{
    $idiomasTerminos = Doctrine_Query::create()->from('Language')->where('isActive = ?', 1)->orderBy('isocode ASC')->execute();
    $nIdiomas = $idiomasTerminos->Count();
    $contIdioma=0;
    foreach($idiomasTerminos as $idioma)
    {
        $idiomas[$contIdioma]['code'] = $idioma->isocode;
        $idiomas[$contIdioma]['name'] = $idioma->title;
        $contIdioma++;
    }

    // RECORRER POSTS
    foreach($_POST as $termino => $array)
    {
        // TERMINOS: AQUELLOS CUYOS VALORES SEAN ARRAY (PARA TODOS LOS IDIOMAS)
        if(is_array($array) /*&& preg_match('/'.$tableName.'\-/', $termino) != false*/)
        {
            // BORRAR
            if(!strlen($array[0]))
            {
                for($idioma=0;$idioma<$nIdiomas;$idioma++)
                {
                    unset(${"LANG_".strtoupper($idiomas[$idioma]['code'])}[$termino]);
                }
                Doctrine_Query::create()->delete('Translation')
                                        ->where('tableName = ?', $tableName)
                                        ->andWhere('token = ?', $token)
                                        ->andWhere('term = ?', stripslashes($termino))
                                        ->execute();
            }
            foreach($array as $idioma => $valor)
            {
                $html = nl2br(/*urldecode(*/$valor/*)*/);
                $html = str_replace("\r\n", "", $html);
                $html = stripslashes($html);
                //echo $idioma . " > " . $valor . "<br>";

                // Borrar termino
                if(!strlen($html)) continue;
                // Actualizar termino
                else ${"LANG_".strtoupper($idiomas[$idioma]['code'])}[stripslashes($termino)]=$html;

                // GUARDAR EN BD
                if(strlen($html))
                {
                    $terminoBD = Doctrine_Query::create()->from('Translation')
                                                        ->where('tableName = ?', $tableName)
                                                        ->andWhere('token = ?', $token)
                                                        ->andWhere('term = ?', stripslashes($termino))
                                                        ->andWhere('isocode = ?', $idiomas[$idioma]['code'])
                                                        ->limit(1)->execute()->getFirst();
                    if(!$terminoBD)
                    {
                        $terminoBD = new Translation();
                    }
                    $terminoBD->isocode = $idiomas[$idioma]['code'];
                    $terminoBD->term = $termino;
                    $terminoBD->tableName = $tableName;
                    $terminoBD->field = $termino;
                    $terminoBD->token = $token;

                    if($terminoBD->translation != $html)
                    {
                        Doctrine_Query::create()->update('Translation')->set('updatedAt', 'NOW()')->where('term = ?', $termino)->execute();
                    }
                    $terminoBD->translation = $html;
                    //$terminoBD->trySave();
                    try
                    {
                        $terminoBD->save();
                    }catch(Exception $e){
                        error_log('Error: ' . __FILE__ . ' linea ' . __LINE__ . $e);
                    }
                }
                // GUARDAR EN BD
            }
        }
    }
}
// MULTIIDIOMA
function fechaIdioma($fecha, $idioma="", $incluirHora=false)
{
    switch($idioma)
    {
        case "":
        case "es":
            if($fecha)
            {
                if($incluirHora) return date("d-m-Y H:i:s", strtotime($fecha));
                else return date("d-m-Y", strtotime($fecha));
            }else return "";
        case "_en":
        case "en":
        default:
            if($fecha)
            {
                if($incluirHora) return date("Y-m-d H:i:s", strtotime($fecha));
                else return date("Y-m-d", strtotime($fecha));
            }else return "";
    }
}

function actualizarTerminosIdioma()
{
    $codigo_idioma = str_replace("_","",$_COOKIE['lang']);
    $terminos = Doctrine_Query::create()->from('Translation')->where('isocode = ?', $_COOKIE['lang'])->execute();
    global $LANG;
    foreach($terminos as $termino)
    {
        $LANG[$termino->term] = $termino->translation;
    }
}

function getHitosTrompetista($trompetistaId, $currentOnly=false, $orderBy='tt.startAt DESC')
{
    $hitosArray = array();

    $hitos = Doctrine_Query::create()->from('TrompetistaTrayectoria tt')
                                    ->leftJoin('tt.TipoOcupacion to')
                                    ->where('tt.idTrompetista = ?', $trompetistaId)
                                    ->orderBy($orderBy)
                                    ->execute();
    foreach($hitos as $hito)
    {
        $ocupacionNombre = getTranslatedField('TipoOcupacion', $hito->TipoOcupacion->token, 'nombre', $_COOKIE['lang']);
        $plazaNombre = getTranslatedField('TipoPlaza', $hito->TipoPlaza->token, 'nombre', $_COOKIE['lang']);
        $pais = Doctrine_Core::getTable('Country')->find($hito->country);

        if($currentOnly && empty($hito->endAt)) $hitosArray[] = $plazaNombre. ' ' . $hito->Entidad->name . ' ' . '(' . $pais->lang .')';
    }
    return $hitosArray;
}

// Busca en tableName los campos fields que estén definidos y que hacen referencia a objetos que va a devolver su id
function filtroWhere($tableName, $fields, $extraWhere="", $whereField='id')
{
    // FILTRAR RESULTADOS
    foreach($fields as $field)
    {
        $where .= $field . ' IS NOT NULL OR ';
    }
    $where = substr($where, 0, -3);

    $filtroWhere = Doctrine_Query::create()->from($tableName)->where($where);
    if(!empty($extraWhere)) $filtroWhere = $filtroWhere->andWhere($extraWhere);
    $filtroWhere = $filtroWhere->execute();

    $opcionesArr = array();
    foreach($filtroWhere as $opcion)
    {
        foreach($fields as $field)
        {
            if(!empty($opcion->{$field})) $opcionesArr[] = $opcion->{$field};
        }
    }
    $opcionesLst = implode(',', array_unique($opcionesArr));
    $where = '';
    if(!empty($opcionesLst)) $where = $whereField . ' IN ('.$opcionesLst.')';
    // FILTRAR RESULTADOS FIN
    return $where;
}

function getCountryNameLang($pais, $isocode)
{
    return $pais->{'title_'.$isocode};
}

function getLanguageName($language, $isocode)
{
    if($isocode == 'es') return $language->description;
    else return $language->title;
}

function getMonthNameLang($monthNumber)
{
    global $LANG;
    $months = array(1 => $LANG['enero'], 2 => $LANG['febrero'], 3 => $LANG['marzo'], 4 => $LANG['abril'], 5 => $LANG['mayo'], 6 => $LANG['junio'], 7 => $LANG['julio'], 8 => $LANG['agosto'], 9 => $LANG['septiembre'], 10 => $LANG['octubre'], 11 => $LANG['noviembre'], 12 => $LANG['diciembre']);
    return $months[$monthNumber];
}

function registrarSubscripcionStripe($tokenStripe, $idPlanStripe, $usuarioWebId, $usuarioWebEmail, $cantidad, $periodicidad)
{
    $customer = \Stripe\Customer::create(array(
    'email' => $usuarioWebEmail,
    "plan" => $idPlanStripe,
    'card'  => $tokenStripe
    ));

    $registrarSubscripcion = new SubscripcionPremium();
    $registrarSubscripcion->idUsuarioWeb = $usuarioWebId;
    $registrarSubscripcion->idPagoStripe = $customer->id;
    $registrarSubscripcion->precio = $cantidad;
    $registrarSubscripcion->pagado = 1;
    $registrarSubscripcion->metodoPago = "Stripe";
    $registrarSubscripcion->endAt = date('Y-m-d', strtotime($periodicidad, strtotime(date('Y-m-d'))));

    try
    {
        $registrarSubscripcion->save();

        $usuarioActivado = Doctrine_core::getTable('WebUser')->find($usuarioWebId);
        $usuarioActivado->is_premium=1;
        $usuarioActivado->premiumStartAt = $registrarSubscripcion->createdAt;
        $usuarioActivado->premiumEndAt = $registrarSubscripcion->endAt;

        try
        {
            $usuarioActivado->save();
            return true;
        }
        catch(Exception $e)
        {
            error_log("SUBSCRIPCION PREMIUM Error: " . $e);
            return false;
        }
    }
    catch(Exception $e)
    {
        error_log("SUBSCRIPCION PREMIUM Error: " . $e);
        return false;
    }
}

function realizarCompraStripe($idVideoleccion, $idUsuario, $precioFinal)
{
	require_once('./stripe/config.php');

	$producto = Doctrine_Core::getTable('Videoleccion')->find($idVideoleccion);
    $productoTitulo = getTranslatedObjectField($producto, 'titulo', $_COOKIE['lang']);
	$usuario = Doctrine_Core::getTable('WebUser')->find($idUsuario);

	$idTarjeta = $_POST['idTarjeta'];
	$idToken = $_POST['stripeToken'];
	$token = \Stripe\Token::retrieve($idToken)->__toArray(true);
	$fingerprint = $token['card']['fingerprint']; // Identificador único de la tarjeta

	$precioFinal = number_format((float) $precioFinal, 2);

	// Si el usuario ya ha realizado alguna compra, lo recuperamos de Stripe a través de su id de cliente
	if ($usuario->idClienteStripe != null) {
		$cliente = \Stripe\Customer::retrieve($usuario->idClienteStripe);
		// Obtenemos las tarjetas del cliente
		$tarjetasCliente = $cliente->sources->all(array(
			"object" => "card"
		));
		$tarjetasCliente = $tarjetasCliente->__toArray(true);
		$idTarjetas = array();
		$fingerprintTarjetas = array();

		foreach ($tarjetasCliente['data'] as $datosTarjeta) {
			array_push($idTarjetas, $datosTarjeta['id']);
			array_push($fingerprintTarjetas, $datosTarjeta['fingerprint']);
		}

		// Comprobamos si la tarjeta usada para la compra ya está registrada, si no, la registramos
		if (!in_array($fingerprint, $fingerprintTarjetas)) {
			$cliente->sources->create(array("source" => $idToken));
		} else {
			// Recorremos las tarjetas del cliente para obtener el id de la que está usando
			for ($i = 0; $i < sizeof($fingerprintTarjetas); $i++) {
				if ($fingerprint == $fingerprintTarjetas[$i]) {
					$idTarjeta = $idTarjetas[$i];
					break;
				}
			}
		}
	} else {
		// Si el usuario está realizando su primera compra, creamos el cliente
		$cliente = \Stripe\Customer::create(array(
			'email' => $usuario->email,
			'source' => $idToken
		));

		$usuario->idClienteStripe = $cliente->id;
        try
        {
		    $usuario->save();
        }
        catch(Exception $e)
        {
            error_log(__FILE__ . " " . __LINE__ . ': ' . $e);
            error_log(__FILE__ . " " . __LINE__ . ': ' . $cliente->id);
        }
	}

	try {
		// Registramos el cobro
		$cobro = \Stripe\Charge::create(array(
			'customer' => $cliente->id,
			'source' => $idTarjeta,
	 		'amount'   => ($precioFinal * 100),
			'currency' => 'EUR',
			'description' => $productoTitulo
		));

        // Registramos en BD
        $comprarVideoleccion = new ComprarVideoleccion();
        $comprarVideoleccion->idUsuarioWeb = $usuario->id;
        $comprarVideoleccion->idVideoleccion = $idVideoleccion;
        $comprarVideoleccion->precio = $precioFinal;
        $comprarVideoleccion->idTarjeta = $idTarjeta;
        try
        {
            $comprarVideoleccion->save();
        }
        catch(Exception $e)
        {
            error_log($e);
        }

	} catch(Stripe_CardError $e) {
	  $error = $e->getMessage();
	} catch (Stripe_InvalidRequestError $e) {
	  // Invalid parameters were supplied to Stripe's API
	  $error = $e->getMessage();
	} catch (Stripe_AuthenticationError $e) {
	  // Authentication with Stripe's API failed
	  $error = $e->getMessage();
	} catch (Stripe_ApiConnectionError $e) {
	  // Network communication with Stripe failed
	  $error = $e->getMessage();
	} catch (Stripe_Error $e) {
	  // Display a very generic error to the user, and maybe send
	  // yourself an email
	  $error = $e->getMessage();
	} catch (Exception $e) {
	  // Something else happened, completely unrelated to Stripe
	  $error = $e->getMessage();
	}

	$resultadoCompra = array('hayError' => false, 'pagado' => false, 'mensajeError' => '');

	if (isset($error)) {
		$resultadoCompra['hayError'] = true;
		$resultadoCompra['mensajeError'] = $error;
	} else {
		$resultadoCompra['hayError'] = false;
		$resultadoCompra['pagado'] = $cobro->paid;
	}

	return $resultadoCompra;
}

function esPremium($usuarioWeb)
{
    $diferenciaFechas = strtotime($usuarioWeb->premiumEndAt)-time();
    $esPremium = ($diferenciaFechas>0?true:false);
    return $esPremium;
}

function getObjLangField($tableName, $idReg, $field, $isocode)
{
    $entidadObj = Doctrine_Core::getTable($tableName)->find($idReg);
    if($entidadObj) $entidadField = getTranslatedObjectField($entidadObj, $field, $isocode);

    return $entidadField;
}

//categorias recursivas devueltas en options
function listadoRecursivoLi($tabla, $selected=null, $actual=null, $campoId='id', $campoName='title', $campoParent='parentId', $padre='null', $espacios='', $clasePrimero='', $clasePadreNull='', $idPrimero='')
{
	$txtPadre=(is_numeric($padre))?' = '.$padre:' is null';
	$listado = Doctrine_Query::create()->from($tabla)->where($campoParent.$txtPadre)->orderBy('position')->execute();
	if(count($listado) > 0){
		echo '<ul class="'.$clasePrimero.'" id="'.$idPrimero.'">';
		$clasePrimero='';
		$idPrimero='';
		foreach($listado as $l){
			echo '<li '.($selected==$l->$campoId ?'class="current"':'').'>
                <a href="'.((isset($l->alternativeLink) && $l->alternativeLink!='' && $l->alternativeLink != null)?$l->alternativeLink:'contenido-'.$l->urlfriend).'" '.($padre=='null' ?'class="'.$clasePadreNull.'"':'').'>'.$l->$campoName.'</a>';
			listadoRecursivoLi($tabla, $selected, $actual, $campoId, $campoName, $campoParent, $l->$campoId, $espacios,$clasePrimero,$clasePadreNull);
			echo '</li>';
		}
		echo '</ul>';
	}
}

function getClientParameter($parametro)
{
    return Doctrine_Core::getTable('Parametro')->findOneByParametro($parametro)->valor;
}
// ADDED
?>