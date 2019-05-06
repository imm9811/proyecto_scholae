<?php
error_reporting(0);
$bd_config = new stdClass;
$bd_config->host = 'localhost';
$bd_config->user = 'root';
$bd_config->pass = '';
$bd_config->db = 'scholae';

// OJO , revisar una vez puesto en produccion
$pathToModels = dirname(__FILE__) . '/../models';
$pathToDoctrine = dirname(__FILE__) . '/../vendor/doctrine/Doctrine.php';

//Cargamos la libreria
require_once $pathToDoctrine;
spl_autoload_register(array('Doctrine', 'autoload'));
spl_autoload_register(array('Doctrine', 'modelsAutoload'));

//Creamos el manager
$manager = Doctrine_Manager::getInstance();

//Configuramos el manager
$manager->setAttribute(Doctrine::ATTR_VALIDATE, Doctrine::VALIDATE_ALL);
$manager->setAttribute(Doctrine::ATTR_EXPORT, Doctrine::EXPORT_ALL);
$manager->setAttribute(Doctrine::ATTR_MODEL_LOADING, Doctrine::MODEL_LOADING_CONSERVATIVE);
//$manager->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, TRUE);
$manager->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, TRUE);

//Creamos la conexion a la db
$conn = Doctrine_Manager::connection('mysql://'.$bd_config->user.':'.$bd_config->pass.'@'.$bd_config->host.'/'.$bd_config->db, 'doctrine');
$conn->setCharset('utf8');

//Condicion para generar los modelos
//si se generan los modelos los header(location no funcionan)
//se genera un modal de bootstrap
if (isset($_REQUEST['generarModelos'])) {
	$_msg=new stdClass();
	$_msg->type='success';
	$_msg->text='Modelos generados correctamente';

    Doctrine_Core::generateModelsFromDb(
            $pathToModels, array('doctrine'), array(
        'generateTableClasses' => TRUE
            )
    );
} else {
    Doctrine_Core::loadModels($pathToModels);
}
?>
