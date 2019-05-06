<?php

/*function enviar_mail($de,$para,$asunto,$body){
    $mail_de=$de;
    $mail_para=$para;
    $asunto_mail = $asunto;
	$body_mail =$body;

	$cabeceras_mail  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras_mail .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$cabeceras_mail .= 'From: ' . $mail_de . "\r\n";
    return mail($mail_para, $asunto_mail, $body_mail, $cabeceras_mail);
} */

//formulario de login
if(isset($_POST['form_login'])){
	if(isset($_POST['email'])){
		$res= Doctrine_Query::create()->from('User')->where('email = ?', $_POST['email'])->andWhere('password = ?', md5($_POST['password']))->andWhere('isActive=1')->limit(1)->execute();
	}else if(isset($_POST['username'])){
		$res= Doctrine_Query::create()->from('User')->where('user = ?', $_POST['username'])->andWhere('password = ?', md5($_POST['password']))->andWhere('isActive=1')->limit(1)->execute();
	}
	
	if($res && $res->Count() != null)
	{
		$user=$res->toArray();
		$_SESSION['user']=$user[0];
		$imagen = Doctrine_Query::create()->from('Files')->where('token = ?', $user[0]['token'])->execute()->getFirst();
		if($imagen){
			$img=$imagen->toArray();
		}else{
			$img = array();
			$img['name']="imagen user";
			$img['filename']="avatar.png";
			$img['filepath']="../intranet/assets/img/default/";
			$img['thumb_filepath']="../intranet/assets/img/default/";
			$img['isActive']=1;
			
		}
		$_SESSION['user']['picture']=$img;
		header('Location:'.$_POST['http-refer']);
	}
	else
	{
		$_msg=new stdClass();
		$_msg->type='danger';
		$_msg->text='Usuario o contraseña incorrectos';
	}
}


//registro
if(isset($_POST['formulario_registro_usuario'])){
	$reg = new User();
	
    $reg->token = date('dmyHis');
    $reg->is_active = 1;
    $reg->user = $_POST['name'];
    $reg->password = md5($_POST['password']);
    $reg->name = $_POST['name'];
    $reg->email = $_POST['email'];
    $reg->lastname = $_POST['lastname'];
    $reg->permisocmc = 0;
    $reg->permisoec = 0;
    $reg->permisocmu = 0;
    $reg->permisoeu = 0;
    $reg->type = 1;
    $reg->phone = $_POST['phone'];
    $reg->pagado_hasta = gmdate("Y-m-d H:i:s",strtotime("now"));
    $reg->options = '0,0,1';
    $msg = $reg->trySave();

    if($msg){
        $mail = Doctrine_Query::create()->from('Emails')->where("title = 'Usuario registrado'")->execute()->getFirst();
        $de = "no-reply@goofix.es";
        $para = $reg->email;
        $asunto = $mail->asunto;
        $body = sustituir($mail->description,$reg);
        enviar_mail($de,$para,$asunto,$body);
    }



}
if(isset($_POST['formulario_registro_empresa'])){
        $reg = new User();

        $reg->token = date('dmyHis');
        $reg->is_active = 1;
        $reg->user = $_POST['fullname'];
        $reg->password = md5($_POST['password']);
        $reg->name = $_POST['fullname'];
        $reg->email = $_POST['email'];
        $reg->lastname = '';
        $reg->permisocmc = 0;
        $reg->permisoec = 0;
        $reg->permisocmu = 0;
        $reg->permisoeu = 0;
        $reg->type = 2;
        $reg->phone = $_POST['phone'];
        $reg->pagado_hasta = date("Y-m-d H:i:s",strtotime("+2 month"));
        $reg->options = '0,0,1';

        $msg = $reg->trySave();
}

//formulario de contacto
if (isset($_POST['form_contacto']))
{
	if($_POST['nombre']=="" || $_POST['email']=="" || $_POST['mensaje']=="")
	{
		$errorEnvio=1;
	}
	else
	{
		$mail_de=$_POST["email"];

		$mail_para="info@dominio.es";
		
		$asunto_mail = 'Contacto desde web';	
		$body_mail ='Usuario: '.$_POST['nombre'].'<br/>'.
					'Email: '.$_POST['email'].'<br/>'.
					'Asunto: '.$_POST['asunto'].'<br/>'.
					'Mensaje: '.'<br/>'.$_POST['mensaje'].'<br/><br/><br/><br/>';							
				
		$cabeceras_mail  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras_mail .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$cabeceras_mail .= 'From: ' . $mail_de . "\r\n";
		if(mail($mail_para, $asunto_mail, $body_mail, $cabeceras_mail))
		{
			$errorEnvio=2;
		}
		else
		{
			$errorEnvio=1;
		}

	}
	
}

//CUANDO EL USUARIO QUIERE RECORDAR LA CONTRASEÑA.
if(isset($_POST['form_recordar']))
{
	$rec = Doctrine_Query::create()->from('User')->where('email = ?', $_POST['email'])->limit(1)->execute();

	if($rec->Count() != null)
	{
		$r=$rec->getFirst();
		//genera una nueva contaseña para modificarla en la base de datos y enviarla al email del usuario.
		$nueva=generaPass();
		
		Doctrine_Query::create()
        ->update('User')
        ->set('pass', '?',md5($nueva))
        ->where('id = ?', $r->id)
        ->execute();
	
	
		//EMAIL DE BIENVENIDA
		$mail_de="dominio.com";
		$mail_para= $r->email;
		$asunto_mail = 'Recuerdo de contraseña';	
		$body_mail = '<p>A continuación se indica tu usuario y tu nueva contraseña.</p><br/<br />
					Usuario: ' . $r->usuario . '<br/>	
					Clave: ' . $nueva . '<br/><br/>'; 
													
		$cabeceras_mail  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras_mail .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$cabeceras_mail .= 'From: ' . $mail_de . "\r\n";
		mail($mail_para, $asunto_mail, $body_mail, $cabeceras_mail);
		
		$norecordado=1;
	}
	else
	{
		$norecordado=2;
	}
}
?>