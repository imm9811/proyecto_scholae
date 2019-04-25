<?php
// SETTINGS
$settings_urlbase = $_config->website;
$settings_urlbasemm = $_config->websitemm;
$settings_email_admin = Doctrine_Core::getTable('Parametro')->findOneByParametro('email')->valor;
$settingsDefaultImage = $settings_urlbase.'images/imageDefault.jpg';


$parametrosCliente = array();
$parametrosCliente['emailAdmin'] = getClientParameter('email');
$parametrosCliente['emailWeb'] = getClientParameter('emailWeb');
$parametrosCliente['phoneWeb'] = getClientParameter('phoneWeb');
$parametrosCliente['phoneWeb2'] = getClientParameter('phoneWeb2');
/* MULTIIDIOMA */
if(isset($_GET['lang']))
{
    $settings_urlbase_lang = $settings_urlbase;
    $settings_urlbase_lang_sinbarra = substr($settings_urlbase, 0, -1);
}
else{
    $settings_urlbase_lang = $settings_urlbase;
    $settings_urlbase_lang_sinbarra = substr($settings_urlbase, 0, -1);
}
/* MULTIIDIOMA */
?>