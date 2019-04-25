<?php
/*
$parametros = array(
    "[THEME-COLOR]",
    "[HEADER-LINK]",
    "[HEADER-LOGO-SRC]",
    "[HEADER-LOGO-WIDTH]",
    "[HEADER-LOGO-HEIGHT]",
    "[HEADER-TITULO]",
    "[HEADER-SUBTITULO]",
    "[BODY-TITULO]",
    "[BODY-SUBTITULO]",
    "[BODY-MENSAJE]",
    "[BODY-LINK-TEXT]",
    "[BODY-LINK]",
    "[BODY-FOOTER]",
    "[FOOTER-LINK-TEXT]",
    "[FOOTER-LINK]",
);

$reemplazos = array(
    "#0ABBAA",
    "http://myinvestmentsadvisor.xerintel.net/devxerintel",
    "http://myinvestmentsadvisor.xerintel.net/devxerintel/images/logo-wide.png",
    "auto",
    "auto",
    "",
    "",
    "Cuenta registrada",
    "Cuenta registrada correctamente",
    "Hola NOMBRE APELLIDOS, has registrado tu cuenta USUARIO con nosotros.
    Puede acceder a su perfil desde el siguiente enlace",
    "Acceder a mi Perfil",
    "http://myinvestmentsadvisor.xerintel.net/devxerintel/es",
    "Gracias.",
    "MyInvestmentsAdvisor.com",
    "http://myinvestmentsadvisor.xerintel.net/devxerintel/es"
);

if(enviarEmail("salcarman@gmail.com", "registro.html", "Registro", $parametros, $reemplazos)) echo '-';
else echo '_';
*/

function enviarEmail($mail_para, $nombre_plantilla, $asunto_mail, $parametros, $reemplazos, $mail_de="")
{
    require_once('class.phpmailer.php');

    $website = Doctrine_Core::getTable('Configs')->find('website')->value;
    $emailFrom = Doctrine_Core::getTable('Configs')->find('configEmail_from')->value;
    $emailFromName = Doctrine_Core::getTable('Configs')->find('configEmail_fromName')->value;
    $settings_email_admin = Doctrine_Core::getTable('Parametro')->findOneByParametro('email')->valor;

    ////////
    $mail = new phpmailer();
    $mail->IsSMTP();
    $mail->Host = "192.168.100.8";
    $mail->IsSendmail();
    $mail->SMTPAuth   = true;
    $mail->Username = 'no-reply@'.$emailFrom;
    $mail->Password = 'zB]+OcHwS43!';
    if($mail_de=="") $mail->From = 'info@'.$emailFrom;
    else $mail->From = $mail_de;
    $mail->FromName = $emailFromName;

    $mail->AddAddress($mail_para);
    //$mail->AddAddress($settings_email_admin); // COPIA ADMIN

    $mail->IsHTML(true);

    $email_body = getEmailTemplateBody($nombre_plantilla, $parametros, $reemplazos);


    $text_body = "Email";
    $mail->Subject = $asunto_mail;
    $mail->Body = '<div style="margin-top: 50px"></div>'.$email_body;
    $mail->AltBody = $text_body;

    if($mail->Send()) return 1;
    else return 0;
}

function enviarEmailParametrosDefecto($mail_para, $mensaje, $codigo_idioma, $nombre_plantilla, $asunto_mail, $mail_de="", $addBCC=false)
{
    require_once('class.phpmailer.php');

    $settings_urlbase = Doctrine_Core::getTable('Configs')->find('website')->value;

    // MANDAR EMAIL
    $parametros = array(
        "[THEME-COLOR]",
        "[HEADER-LINK]",
        "[HEADER-LOGO-SRC]",
        "[HEADER-LOGO-WIDTH]",
        "[HEADER-LOGO-HEIGHT]",
        "[HEADER-TEXTO-LOGO]",
        "[HEADER-TITULO]",
        "[HEADER-SUBTITULO]",
        "[BODY-TITULO]",
        "[BODY-SUBTITULO]",
        "[BODY-MENSAJE]",
        "[BODY-LINK-TEXT]",
        "[BODY-LINK]",
        "[BODY-FOOTER]",
        "[FOOTER-LINK-TEXT]",
        "[FOOTER-LINK]",
        "[BODY-FOOTER-LEGAL-TEXTS]",
        "[PREMIUM-COLOR]"
    );

    $reemplazos = array(
        "#3AC2CF",
        $settings_urlbase,
        $settings_urlbase."assets/img/logos/logo.png",
        "auto",
        "auto",
        getTranslatedTerm('virrey-eslogan', $codigo_idioma),
        str_replace("-","<br>", $asunto_mail),
        "",
        "",
        "",
        $mensaje,
        "",
        $settings_urlbase,
        "",
        "Virrey Inmobiliaria",
        $settings_urlbase,
        '',
        '#3AC2CF'
    );

    $website = Doctrine_Core::getTable('Configs')->find('website')->value;
    $emailFrom = Doctrine_Core::getTable('Configs')->find('configEmail_from')->value;
    $emailFromName = Doctrine_Core::getTable('Configs')->find('configEmail_fromName')->value;
    $settings_email_admin = Doctrine_Core::getTable('Parametro')->findOneByParametro('email')->valor;

    ////////
    $mail = new phpmailer();
    $mail->IsSMTP();
    $mail->Host = "192.168.100.8";
    $mail->IsSendmail();
    $mail->SMTPAuth   = true;
    $mail->Username = 'no-reply@'.$emailFrom;
    $mail->Password = 'zB]+OcHwS43!';
    if($mail_de=="") $mail->From = 'info@'.$emailFrom;
    else $mail->From = $mail_de;
    $mail->FromName = $emailFromName;

    $mail->AddAddress($mail_para);
    if($addBCC) $mail->AddBCC($settings_email_admin); // COPIA ADMIN

    $mail->IsHTML(true);

    $email_body = getEmailTemplateBody($nombre_plantilla, $parametros, $reemplazos);


    $text_body = "Email";
    $mail->Subject = $asunto_mail;
    $mail->Body = $email_body;
    $mail->AltBody = $text_body;

    if($mail->Send()) return 1;
    else return 0;
}

function getEmailTemplateBody($nombre_plantilla, $parametros, $reemplazos)
{
    $email_template = file_get_contents('/home/reyomar/public_html/devxerintel/mail-templates/'.$nombre_plantilla);

    return str_replace($parametros, $reemplazos, $email_template);
}
?>