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
		$res= Doctrine_Query::create()->from('User')->where('email = ?', $_POST['email'])->andWhere('password = ?', md5($_POST['password']))->andWhere('is_active=1')->limit(1)->execute();
	}else if(isset($_POST['username'])){
		$res= Doctrine_Query::create()->from('User')->where('user = ?', $_POST['username'])->andWhere('password = ?', md5($_POST['password']))->andWhere('is_active=1')->limit(1)->execute();
	}

	if($res && $res->Count() != null)
	{
		$user=$res->toArray();
		$_SESSION['user']=$user[0];
		header('Location: headers'/*.$_POST['http-refer']*/);
	}
	else
	{
		$_msg=new stdClass();
		$_msg->type='danger';
		$_msg->text='Usuario o contraseña incorrectos';
	}
}


if(isset($_POST["btnValidarEncuestaPorUsuario"])){

        $reg= Doctrine_Query::create()->from('HistoricoResultado')->where('idReto = ?',$_POST['id'])->execute()->getFirst();
        $reto= Doctrine_Query::create()->from('Reto')->where('id = ?',$_POST['id'])->execute()->getFirst();
        $equipoRetador= Doctrine_Query::create()->from('Equipo')->where('id = ?',$reto->idRetador)->execute()->getFirst();
        $equipoRetado= Doctrine_Query::create()->from('Equipo')->where('id = ?',$reto->idContrincante)->execute()->getFirst();

    if($_POST["validarEncuesta"] == 1){

        if($reto->idRetador == $_SESSION['userWeb']['id'] || $equipoRetador->idCreador == $_SESSION['userWeb']['id']){
            $reg->valoracionRetador = 1;
            $reg->valoracionRetadorAlContrincante = $_POST['estrellas'];
            $reg->save();

            $reto->estado= 3;
            $reto->save();
        }
        elseif($reto->idContrincante == $_SESSION['userWeb']['id'] || $equipoRetado->idCreador == $_SESSION['userWeb']['id']){
            $reg->valoracionRetado = 1;
            $reg->valoracionRetadoAlContrincante = $_POST['estrellas'];
            $reg->save();

            $reto->estado= 3;
            $reto->save();
        }else{

        }

    }elseif($_POST["validarEncuesta"] == 2){

        if($reto->idRetador == $_SESSION['userWeb']['id'] || $equipoRetador->idCreador == $_SESSION['userWeb']['id']){
            $reg->valoracionRetador = 2;
            $reg->valoracionRetadorAlContrincante = $_POST['estrellas'];
            $reg->comentarioRetador = $_POST['comentarioValidacion'];
            $reg->save();

            $reto->estado= 2;
            $reto->save();
        }
        elseif($reto->idContrincante == $_SESSION['userWeb']['id'] || $equipoRetado->idCreador == $_SESSION['userWeb']['id']){
            $reg->valoracionRetado = 2;
            $reg->valoracionRetadoAlContrincante = $_POST['estrellas'];
            $reg->comentarioRetado = $_POST['comentarioValidacion'];
            $reg->save();

            $reto->estado= 2;
            $reto->save();
        }else{

        }



}
?>
		<script>
			setTimeout(function(){ window.location = "../misRetos"; }, 1000);
		</script>
<?
}



if(isset($_POST['enviarEncuesta'])){


    $reg2= Doctrine_Query::create()->from('Reto')->where('id = ?',$_POST['idReto'])->execute()->getFirst();

    $reg2->valorado=1;
    $reg2->endAt= date('Y-m-d');
    $reg2->save();


    $reg = new HistoricoResultado();

    $reg->token = $_POST['tokenReto'];
    $reg->idReto = $_POST['idReto'];
    $reg->ganador = $_POST['ganador'];
    if($_POST['ganador'] == 0)
    {
        $reg->empate = 1;
    }
    $reg->createdAt = date("Y-m-d H:i:s");
    $reg->campoNumerico = $_POST['campoNumerico'];
    $reg->campoTiempo = $_POST['campoTiempo'];
    $reg->idGanador = $_POST['idGanador'];
    $reg->idGanadorEquipo = $_POST['idGanadorEquipo'];
    $reg->comentario = $_POST['comentario'];

    $reg->save();


        $arrays = $_POST['colectivoUsuariosArray'];
                foreach ($arrays as $array)
                {

                $user= Doctrine_Query::create()->from('UserWeb')->where('id = ?', $array)->execute()->getFirst();

                $reg2 = new HistoricoResultadoConex();
                $reg2->idReto = $_POST['idReto'];
                $reg2->idGanadorUser = $user->id;
                $reg2->save();
                }


        $arrays1 = $_POST['colectivoEquiposArray'];
                foreach ($arrays1 as $array1)
                {

                $equipo= Doctrine_Query::create()->from('Equipo')->where('id = ?', $array1)->execute()->getFirst();

                $reg2 = new HistoricoResultadoConex();
                $reg2->idReto = $_POST['idReto'];
                $reg2->idGanadorEquipo = $equipo->id;
                $reg2->save();
                }

    if($_FILES['fichero']['tmp_name']){
    if(is_uploaded_file($_FILES['fichero']['tmp_name'])) { // verifica haya sido cargado el archivo
        $ruta= "uploads/encuesta/".$_FILES['fichero']['name']; // Se guardaría dentro de "carpeta" con el nombre original
// $ruta= "carpeta/nuevo_nombre.jpg"; si también se quiere renombrar
move_uploaded_file($_FILES['fichero']['tmp_name'], $ruta);
                    //echo "<b>Upload exitoso!. Datos:</b><br>";
            //echo "Nombre: <i><a href=\"".$_FILES['fichero']['name']."\">".$_FILES['fichero']['name']."</a></i><br>";
            //echo "Tipo MIME: <i>".$_FILES['fichero']['type']."</i><br>";
                    //echo "Peso: <i>".$_FILES['fichero']['size']." bytes</i><br>";
                        //echo "<br><hr><br>";
        }

	$reg_file = new Files();
    $reg_file->token = $_POST['tokenReto'];
    $reg_file->mime = $_FILES['fichero']['type'];
	$reg_file->name = $_FILES['fichero']['name'];
	$reg_file->filename = $_POST['tokenReto'];
	$reg_file->filepath = $ruta;
	$reg_file->size = $_FILES['fichero']['size'];
    $reg_file->width = 0;
    $reg_file->height = 0;
    $reg_file->thumb_width = 0;
    $reg_file->thumb_height = 0;
    $reg_file->thumb_filepath = $ruta."thumbnail/";
    $reg_file->created_at = new Doctrine_Expression('NOW()');
    $reg_file->is_active = 1;
    $reg_file->save();

}

                    $reto= Doctrine_Query::create()->from('Reto')->where('id = ?', $_POST['idReto'])->execute()->getFirst();
                    $retador= Doctrine_Query::create()->from('UserWeb')->where('id = ?', $reto->idRetador)->execute()->getFirst();
                    $retado= Doctrine_Query::create()->from('UserWeb')->where('id = ?',  $reto->idContrincante)->execute()->getFirst();

                    $mailDe="hola@godueling.com";

                    $mail_paraRetador= $retador->email;
                    $mail_paraRetado= $retado->email;

                    //$mail_paraRetador= "loquequieras200@yopmail.com"; pruebas
                    //$mail_paraRetado= "loquequieras300@yopmail.com"; pruebas

                    //$mailDe= "loquequieras2@yopmail.com";
                    //$mail_para= "loquequieras2@yopmail.com";


                    $url= 'http://dueling.xerintel.net/encuestas/'.$reto->id;

                    //$urlActivacion='http://gonzaloapp.xerintel.net/activa.php?e='.md5($reg->email).'&t='.md5($reg->token);

                    // $urlActivacion='http://gonzaloapp.xerintel.net/activarCuenta?e='.md5($reg->email).'&t='.md5($reg->token);

                    include("mails/validarEncuestaCorreo.php");

        $url= 'http://dueling.xerintel.net/versus/'.$_GET['id'];

?>

	<script>
		setTimeout(function(){ window.location = "<?=$url?>"; }, 1500);
	</script>

<?

}






//formulario de contacto
if (isset($_POST['btnContacto']))
{
	if($_POST['nombre']=="" || $_POST['email']=="" || $_POST['mensaje']=="")
	{
		$errorEnvio=1;
	}
	else
	{
		$mail_de=$_POST["email"];

		$mail_para="hola@dueling.es";

		$asunto_mail = 'Contacto desde web';
		$body_mail ='Usuario: '.$_POST['nombre'].'<br/>'.
					'Email: '.$_POST['email'].'<br/>'.
					'Telefono: '.$_POST['telefono'].'<br/>'.
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
	$rec = Doctrine_Query::create()->from('UserWeb')->where('email = ?', $_POST['email'])->limit(1)->execute();

	if($rec->Count() != null)
	{
		$r=$rec->getFirst();
		//genera una nueva contaseña para modificarla en la base de datos y enviarla al email del usuario.
		$nueva=generaPass();

		Doctrine_Query::create()
        ->update('UserWeb')
        ->set('clave', '?',md5($nueva))
        ->where('id = ?', $r->id)
        ->execute();


		//EMAIL DE BIENVENIDA
		$mail_de="hola@godueling.com";
		$mail_para= $r->email;
		$asunto_mail = 'Recuerdo de contraseña';
		$body_mail = '<p>A continuación se indica tu email y tu nueva contraseña.</p><br/<br />
					Usuario: ' . $r->username . '<br/>
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




if(isset($_POST['btnRegistro']))
{
	$rec = Doctrine_Query::create()->from('UserWeb')->where('email = ?', $_POST['email'])->andWhere('deleted = 0')->limit(1)->execute()->getFirst();
	if($rec->id)
	{
		$errorRegistro=1;
	}
	else
	{
		$reg = new UserWeb();
		$reg->token=date('dmYHis');
        $reg->name=$_POST['name'];
        $reg->username=$_POST['username'];
		$reg->email=$_POST['email'];
		$reg->clave=md5($_POST['clave']);
		$reg->phone=$_POST['phone'];
		$reg->isActive=1;
		
		if($_FILES['fichero']['tmp_name']){		
			$ruta= "uploads/imgsPerfil/".$reg->token .".jpg"; 
			$ruta2= $settings_urlbase."uploads/imgsPerfil/".$reg->token .".jpg"; 
			move_uploaded_file($_FILES['fichero']['tmp_name'], $ruta2);
			$reg->imgPerfil = $ruta;
		}

		try
		{
			$reg->save();
			$errorRegistro=2;
			$_SESSION['userWeb'] = array();
			$_SESSION['userWeb']['id']=$reg->id;
            $_SESSION['userWeb']['username']=$reg->username;
	        $_SESSION['userWeb']['email']=$reg->email;
	        $_SESSION['userWeb']['name']=$reg->name;
			$_SESSION['userWeb']['phone']=$reg->phone;
			$_SESSION['userWeb']['isActive']=$reg->isActive;
			$mail_de=$_POST["email"];

			$mail_para="hola@dueling.es";

			$asunto_mail = 'Nuevo usuario registrado';
			$body_mail ='Nombre: '.$reg->name.'<br/>'.
						'Email: '.$reg->email.'<br/>'.
						'Telefono: '.$reg->phone.'<br/><br/><br/><br/>
						.';

			$cabeceras_mail  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras_mail .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$cabeceras_mail .= 'From: ' . $mail_de . "\r\n";
			mail($mail_para, $asunto_mail, $body_mail, $cabeceras_mail);
		}
		catch(Exception $e)
		{
			error_log("Error al registrar : " . $e);
			$errorRegistro=3;
		}
	}
}

if(isset($_POST['btnLogin']))
{
	$rec = Doctrine_Query::create()->from('UserWeb')->where('username = ?', $_POST['username'])->andWhere('clave = ?', md5($_POST['password']))->andWhere('deleted = 0')->limit(1)->execute()->getFirst();
	if($rec->id)
	{
		$_SESSION['userWeb'] = array();
		$_SESSION['userWeb']['id']=$rec->id;
        $_SESSION['userWeb']['email']=$rec->email;
        $_SESSION['userWeb']['name']=$rec->name;
		$_SESSION['userWeb']['phone']=$rec->phone;
		$_SESSION['userWeb']['isActive']=$rec->isActive;
        $_SESSION['userWeb']['username']=$rec->username;
		$login=1;


        if($_SESSION["urlRedireccion"])
        {
		?>
		<script>
			setTimeout(function(){ window.location = "<?=$_SESSION["urlRedireccion"]?>"; }, 1000);
		</script>

		<?php
	}else
        {
    ?>
		<script>
			setTimeout(function(){ window.location = "misRetos"; }, 1000);
		</script>
    <?
	    }
    }
	else
	{
		$login=2;
	}
}


if(isset($_POST['btnEditarPerfil']))
{		


        $reg= Doctrine_Query::create()->from('UserWeb')->where('id = ?',$_POST['id'])->execute()->getFirst();
        $reg->name=$_POST['name'];
        $reg->email=$_POST['email'];
        $reg->phone=$_POST['phone'];
        $reg->username=$_POST['username'];
        $reg->clave=($_POST['password']!='')?md5($_POST['password']):$reg->clave;
	
	
		if($_FILES['fichero']['tmp_name']){		
			$ruta= "uploads/imgsPerfil/".$reg->token .".jpg"; 
			$ruta2= $settings_urlbase."uploads/imgsPerfil/".$reg->token .".jpg"; 
			move_uploaded_file($_FILES['fichero']['tmp_name'], $ruta2);
			$reg->imgPerfil = $ruta;
		}
		
		
		
		try
		{

			$reg->save();
			$errorModificarPerfil=2;
		}
		catch(Exception $e)
		{
			error_log("Error al modificar : " . $e);
			$errorModificarPerfil=3;
		}
	}

    if(isset($_POST['btnCrearEquipo']))
{


        $reg = new Equipo();
        $reg->token=date('dmYHis');
        $reg->idCreador=$_POST['id'];
        $reg->nombre=$_POST['nombre'];
        $reg->descripcion=$_POST['descripcion'];
		$reg->save();


		try
		{

        $arrays = $_POST['usuariosEquipo'];
		$token= date('YmdHis');

        foreach ($arrays as $array) {


		        $token=intval($token)+1;

                $reg2 = new EquipoConexTemporal();
                $reg2->idUsuarioWeb=$array;
                $reg2->idEquipo=$reg->id;
				$reg2->tokenUnico = $token;
                $reg2->save();

								$creadorEquipo= Doctrine_Query::create()->from('UserWeb')->where('id = ?',$reg->idCreador)->execute()->getFirst();
								$usuarioInvitado= Doctrine_Query::create()->from('UserWeb')->where('id = ?',$reg2->idUsuarioWeb)->execute()->getFirst();

								$nombre= $creadorEquipo->name;
								$mailDe= $creadorEquipo->email;
								$mail_para= $usuarioInvitado->email;


							$urlActivacion= 'http://dueling.xerintel.net/activation.php?tokenUnico='.$reg2->tokenUnico;

                            include("mails/invitarUsuarioAEquipo.php");

        }
		$errorModificarEquipo=2;
        ?>
    <?php
		}
		catch(Exception $e)
		{
			error_log("Error al modificar : " . $e);
			$errorModificarEquipo=3;
		}
	}


    if(isset($_POST['btnBorrarEquipo']))
        {

        $reg= Doctrine_Query::create()->from('Equipo')->where('id = ?',$_POST['id'])->execute()->getFirst();
        $reg->eliminado=1;

        $reg->save();

    }

    if(isset($_POST['btnEditarEquipo']))
        {

        $reg= Doctrine_Query::create()->from('Equipo')->where('id = ?',$_POST['id'])->execute()->getFirst();
        $reg->nombre=$_POST['nombre'];
        $reg->descripcion=$_POST['descripcion'];
		$reg->id=$_POST['id'];
        $reg->save();

		try
		{

        //$reg3= Doctrine_Query::create()->delete('EquipoConex')->where('idEquipo = ?',$_POST['id'])->execute();
        $token= date('YmdHis');
        $reg3= Doctrine_Query::create()->from('EquipoConexTemporal')->where('idEquipo = ?',$_POST['id'])->execute();
        $reg4= Doctrine_Query::create()->from('EquipoConex')->where('idEquipo = ?',$_POST['idEquipo'])->execute();
        $arrays = $_POST['usuariosEquipo'];

        foreach($reg3 as $user){
                if (!in_array($user->idUsuarioWeb, $arrays)){
                    $user->delete();
                }

            }

            foreach($reg4 as $user){
                if (!in_array($user->idUsuarioWeb, $arrays)) {
                    $user->delete();
                }
            }


	   foreach ($arrays as $array) {

            $encontrado = false;

            foreach($reg3 as $user){

		        if($array == $user->idUsuarioWeb){
                        $encontrado = true;
					}
            }

            if($encontrado == false){
                $token=intval($token)+1;
				$reg2 = new EquipoConexTemporal();
				$reg2->idUsuarioWeb=$array;
    			$reg2->idEquipo=$reg->id;
				$reg2->tokenUnico = $token;
				$reg2->save();

                $creadorEquipo= Doctrine_Query::create()->from('UserWeb')->where('id = ?',$reg->idCreador)->execute()->getFirst();
								$usuarioInvitado= Doctrine_Query::create()->from('UserWeb')->where('id = ?',$reg2->idUsuarioWeb)->execute()->getFirst();

								$nombre= $creadorEquipo->name;
								$mailDe= $creadorEquipo->email;
								$mail_para= $usuarioInvitado->email;


							$urlActivacion= 'http://dueling.xerintel.net/activation.php?tokenUnico='.$reg2->tokenUnico;
								include("mails/invitarUsuarioAEquipo.php");
            }

		}


		$errorModificarEquipo=2;
		}
		catch(Exception $e)
		{
			error_log("Error al modificar : " . $e);
			$errorModificarEquipo=3;
		}
	}




        if(isset($_POST['btnInvitarAmigo']))
                {

		try
		{
                    $reg= Doctrine_Query::create()->from('UserWeb')->where('id = ?',$_POST['id'])->execute()->getFirst();

                    $nombre= $reg->name;
                    $mailDe= $reg->email;
                    $mail_para= $_POST['email'];

                    //$mailDe= "loquequieras2@yopmail.com";
                    //$mail_para= "loquequieras2@yopmail.com";


                    $urlRegistro= 'http://dueling.xerintel.net/registro';

                    //$urlActivacion='http://gonzaloapp.xerintel.net/activa.php?e='.md5($reg->email).'&t='.md5($reg->token);

                    // $urlActivacion='http://gonzaloapp.xerintel.net/activarCuenta?e='.md5($reg->email).'&t='.md5($reg->token);

                    include("mails/invitarAmigoCorreo.php");

		            $errorInvitarAmigo=2;
		}
		catch(Exception $e)
		{
			error_log("Error al modificar : " . $e);
			$errorInvitarAmigo=3;
		}
	}


        if(isset($_POST['btnCrearReto']))
        {


    	    $reg= new Reto();

			$reg->token= date('dmYHis');
			$reg->isActived=1;
			$reg->title_es=$_POST['nombreES'];
            $reg->title_en=$_POST['nombreES'];
            /* Si vuelve a querer poner el campo nombre ingles en el crear reto, borrar el otro reg->title_en y descomentar este: $reg->title_en=$_POST['nombreEN'];  */
            $reg->descripcion_es=$_POST['descripcionES'];
            $reg->descripcion_en=$_POST['descripcionES'];
            /* Si vuelve a querer poner el campo descripcion ingles en el crear reto, borrar el otro reg->descripcion_en y descomentar este: $reg->descripcion_en=$_POST['descripcionEN'];*/
            //$reg->descripcion=$_POST['descripcion'];
            $reg->privacidad=$_POST['privacidad'];
            $reg->fecha=$_POST['fecha'];
            $reg->hora=$_POST['campoHora'];
            $reg->lugar=$_POST['lugar'];
            $reg->recompensa=$_POST['recompensa'];
            $reg->numeroMaxPlazas=$_POST['numeroMaxPlazas'];
            $reg->numeroMaxEquipos=$_POST['numeroMaxEquipos'];
            $reg->idTipo=$_POST['retoTipo'];
            $reg->metodologia=$_POST['metodologia'];
            $reg->valorado=0;
            $reg->juez=($_POST['juez'] ? $_POST['juez'] : $_SESSION['userWeb']['id']);

            $reg->recurrencia=$_POST['recurrencia'];
            $reg->idModalidad=$_POST['modalidad'];
            $reg->idCreador=$_POST['idCreador'];
            //$reg->idRetador=$_POST['idCreador'];

            $reg->createdAt = date("Y-m-d H:i:s");
            $reg->save();

    $yaHay= Doctrine_Query::create()->from('RelacionPrimariaReto')->where('idReto = ?', $reg->id)->andWhere('idUsuario = ?', $_SESSION['userWeb']['id'])->execute()->getFirst();

    if($yaHay)
    {

    }
    else
    {

            if($reg->juez == $reg->idCreador)
            {
            $reg5= new RelacionPrimariaReto();
            $reg5->idUsuario = $_SESSION['userWeb']['id'];
            $reg5->idReto = $reg->id;
            $reg5->save();
            }
            else
            {
            $reg5= new RelacionPrimariaReto();
            $reg5->idUsuario = $_SESSION['userWeb']['id'];
            $reg5->idReto = $reg->id;
            $reg5->save();

            $reg6= new RelacionPrimariaReto();
            $reg6->idUsuario = $reg->juez;
            $reg6->idReto = $reg->id;
            $reg6->save();
            }

    }

            if($reg->recurrencia != 0){


            $reg->retoPadre = $reg->id;
            $reg->save();

            }

            //error_log("la imagen es : ". $_FILES['fichero']['tmp_name']);

                        if($_FILES['fichero']['tmp_name']){
                            //error_log("entra en el if");
                if(is_uploaded_file($_FILES['fichero']['tmp_name'])) { // verifica haya sido cargado el archivo
                    $ruta= "uploads/retos/".$_FILES['fichero']['name']; // Se guardaría dentro de "carpeta" con el nombre original
                    //error_log("entra aqui 2, la ruta es : ". $ruta);
            // $ruta= "carpeta/nuevo_nombre.jpg"; si también se quiere renombrar
            move_uploaded_file($_FILES['fichero']['tmp_name'], $ruta);
                                //echo "<b>Upload exitoso!. Datos:</b><br>";
                        //echo "Nombre: <i><a href=\"".$_FILES['fichero']['name']."\">".$_FILES['fichero']['name']."</a></i><br>";
                        //echo "Tipo MIME: <i>".$_FILES['fichero']['type']."</i><br>";
                                //echo "Peso: <i>".$_FILES['fichero']['size']." bytes</i><br>";
                                    //echo "<br><hr><br>";
                    }

            	$reg_file = new Files();
                $reg_file->token = date('dmYHis');
                $reg_file->mime = $_FILES['fichero']['type'];
            	$reg_file->name = $_FILES['fichero']['name'];
            	$reg_file->filename = $reg->token;
            	$reg_file->filepath = $ruta;
            	$reg_file->size = $_FILES['fichero']['size'];
                $reg_file->width = 0;
                $reg_file->height = 0;
                $reg_file->thumb_width = 0;
                $reg_file->thumb_height = 0;
                $reg_file->thumb_filepath = $ruta."thumbnail/";
                $reg_file->created_at = new Doctrine_Expression('NOW()');
                $reg_file->is_active = 1;

                try
                {
                    $reg_file->save();
                }
                catch(Exception $r)
                {
                    error_log("error guardar file bbdd " . $r);
                }

                }else{

                }

                if($reg->privacidad==1 && $reg->idTipo == 1)
                {

                    $reg->idRetador = $_SESSION['userWeb']['id'];
                    $reg->save();

                }

        if($_POST['1vs1UsuContri'])
        {
            /*$reg->idContrincante=$_POST['1vs1UsuContri'];*/

        $mailDestinatario= Doctrine_Query::create()->from('UserWeb')->where('id = ?',$_POST['1vs1UsuContri'])->execute()->getFirst();
        $url= 'http://dueling.xerintel.net/versus/'.$reg->id;

        $mail_de="hola@dueling.es";
		$mail_para= $mailDestinatario->email;
        $nombreReto = $reg->title_es;


        include("mails/1vs1ContrincanteCorreo.php");


        }elseif($_POST['1vs1EquiContri']){

        /*$reg->idContrincante=$_POST['1vs1EquiContri'];*/
        $url= 'http://dueling.xerintel.net/versus/'.$reg->id;

        $equipoAenviar= Doctrine_Query::create()->from('Equipo')->where('id = ?', $_POST['1vs1EquiContri'])->execute()->getFirst();
        $mailDestinatario1= Doctrine_Query::create()->from('UserWeb')->where('id = ?', $equipoAenviar->idCreador)->execute()->getFirst();

        $mail_de="hola@dueling.es";
		$mail_para= $mailDestinatario1->email;
        $nombreReto = $reg->title_es;

		include("mails/1vs1EquipoCorreo.php");

        }

		try
		{

                $errorCrearReto=2;




                        /*
                $reg3= Doctrine_Query::create()->delete('RetoConex')->where('idReto = ?',$_POST['idReto'])->execute();

                        */


                if(count($_POST['colectivoUsuariosArray'])>0){

                $url= 'http://dueling.xerintel.net/versus/'.$reg->id;

                $asunto_mail = '¡Te han retado!';

                $body_mail ='¡Te han retado a un duelo!<br/><br/><br/><br/>
						Si quieres aceptarlo pincha aquí para unirte: '.$url.'';

                $arrays = $_POST['colectivoUsuariosArray'];
                foreach ($arrays as $array) {

                $user= Doctrine_Query::create()->from('UserWeb')->where('id = ?', $array)->execute()->getFirst();

                $reg2 = new CronCorreoRetarColectivos();
                $reg2->mailPara=$user->email;
                $reg2->mail_de=$_SESSION['userWeb']['email'];
                $reg2->body_mail=$body_mail;
                $reg2->asunto_mail=$asunto_mail;
                $reg2->createdAt = date("Y-m-d H:i:s");
                $reg2->nombreReto = $reg->title_es;
                $reg2->urlReto = $url;
                $reg2->save();
                }
                }elseif(count($_POST['colectivoEquiposArray'])>0){

                                $url= 'http://dueling.xerintel.net/versus/'.$reg->id;

                $asunto_mail = '¡Han retado a tu equipo!';

                $body_mail ='¡A tu equipo le han retado a duelo!<br/><br/><br/><br/>
						Si quieres aceptarlo pincha aquí para unirte: '.$url.'';

                //error_log(print_r( $_POST['colectivoEquiposArray'], true));

                $arrays1 = $_POST['colectivoEquiposArray'];
                //error_log(print_r($arrays1, true));
                foreach ($arrays1 as $array1) {

                $equipo= Doctrine_Query::create()->from('Equipo')->where('id = ?', $array1)->execute()->getFirst();

                //error_log("id".$equipo->id);

                $userCreador= Doctrine_Query::create()->from('UserWeb')->where('id = ?', $equipo->idCreador)->execute()->getFirst();

                $reg4 = new CronCorreoRetarColectivos();
                //error_log("idUserCreador".$userCreador->id);
                //error_log($userCreador->email);
                $reg4->mailPara=$userCreador->email;
                $reg4->mail_de=$_SESSION['userWeb']['email'];
                $reg4->body_mail=$body_mail;
                $reg4->createdAt = date("Y-m-d H:i:s");
                $reg4->asunto_mail=$asunto_mail;
                $reg4->nombreReto = $reg->title_es;
                $reg4->urlReto = $url;
                $reg4->save();
                }
                }else{

                }


        if($_POST['sugerenciaModalidad']){

            $mail_de= $_SESSION['userWeb']['email'];

			$mail_para="hola@godueling.com";

            $sugerencia= $_POST['sugerenciaModalidad'];

			$asunto_mail = 'Sugerencia para modalidad';
			$body_mail ='Sugerencia recomendada por el cliente: '.$sugerencia.'<br/><br/><br/><br/>
						Si te gusta la modalidad recomendada, puedes crearla directamente desde la intranet.';

			$cabeceras_mail  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras_mail .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$cabeceras_mail .= 'From: ' . $mail_de . "\r\n";
			mail($mail_para, $asunto_mail, $body_mail, $cabeceras_mail);

        }else{

        }




        ?>
    <?php
		}
		catch(Exception $e)
		{
			error_log("Error al crear : " . $e);
			$errorCrearReto=3;
		}

}


        if(isset($_POST['btnEditarReto']))
                {

                $reg= Doctrine_Query::create()->from('Reto')->where('id = ?',$_POST['id'])->execute()->getFirst();
    			$reg->title_es=$_POST['nombreES'];
                $reg->title_en=$_POST['nombreES'];
                /* Si vuelve a querer poner el campo nombre ingles en el editar reto, borrar el otro reg->title_en y descomentar este: $reg->title_en=$_POST['nombreEN'];  */
                $reg->descripcion_es=$_POST['descripcionES'];
                $reg->descripcion_en=$_POST['descripcionES'];
                /* Si vuelve a querer poner el campo descripcion ingles en el editar reto, borrar el otro reg->descripcion_en y descomentar este: $reg->descripcion_en=$_POST['descripcionEN'];*/
                $reg->fecha=$_POST['fecha'];
                $reg->lugar=$_POST['lugar'];
                $reg->hora=$_POST['campoHora'];
                $reg->juez=$_POST['juez'];
                $reg->numeroMaxPlazas=$_POST['numeroMaxPlazas'];
                $reg->numeroMaxEquipos=$_POST['numeroMaxEquipos'];
                $reg->idTipo=$_POST['retoTipo'];
                $reg->metodologia=$_POST['metodologia'];
                $reg->recurrencia=$_POST['recurrencia'];
                $reg->idModalidad=$_POST['modalidad'];
                $reg->privacidad=$_POST['privacidad'];
                $reg->recompensa=$_POST['recompensa'];

                if($reg->juez == NULL)
                    $reg->juez= $reg->idCreador;

                $reg->save();

    $yaHay= Doctrine_Query::create()->from('RelacionPrimariaReto')->where('idReto = ?', $reg->id)->andWhere('idUsuario = ?', $_SESSION['userWeb']['id'])->execute()->getFirst();

    if($yaHay)
    {

    }
    else
    {
        $reg5= new RelacionPrimariaReto();
        $reg5->idUsuario = $_SESSION['userWeb']['id'];
        $reg5->idReto = $reg->id;
        $reg5->save();
    }


                if($_FILES['fichero']['tmp_name']){
                            //error_log("entra en el if");
                if(is_uploaded_file($_FILES['fichero']['tmp_name'])) { // verifica haya sido cargado el archivo
                    $ruta= "uploads/retos/".$_FILES['fichero']['name']; // Se guardaría dentro de "carpeta" con el nombre original
                    //error_log("entra aqui 2, la ruta es : ". $ruta);
            // $ruta= "carpeta/nuevo_nombre.jpg"; si también se quiere renombrar
            move_uploaded_file($_FILES['fichero']['tmp_name'], $ruta);
                                //echo "<b>Upload exitoso!. Datos:</b><br>";
                        //echo "Nombre: <i><a href=\"".$_FILES['fichero']['name']."\">".$_FILES['fichero']['name']."</a></i><br>";
                        //echo "Tipo MIME: <i>".$_FILES['fichero']['type']."</i><br>";
                                //echo "Peso: <i>".$_FILES['fichero']['size']." bytes</i><br>";
                                    //echo "<br><hr><br>";
                    }

            	$reg_file = new Files();
                $reg_file->token = $reg->token;
                $reg_file->mime = $_FILES['fichero']['type'];
            	$reg_file->name = $_FILES['fichero']['name'];
            	$reg_file->filename = $reg->token;
            	$reg_file->filepath = $ruta;
            	$reg_file->size = $_FILES['fichero']['size'];
                $reg_file->width = 0;
                $reg_file->height = 0;
                $reg_file->thumb_width = 0;
                $reg_file->thumb_height = 0;
                $reg_file->thumb_filepath = $ruta."thumbnail/";
                $reg_file->created_at = new Doctrine_Expression('NOW()');
                $reg_file->is_active = 1;

                try
                {
                    $reg_file->save();
                }
                catch(Exception $r)
                {
                    error_log("error guardar file bbdd " . $r);
                }

                }else{

                }


        		try
        		{


                        if($_POST['1vs1UsuContri'])
                    {
                        /*$reg->idContrincante=$_POST['1vs1UsuContri'];*/

                    $mailDestinatario= Doctrine_Query::create()->from('UserWeb')->where('id = ?',$_POST['1vs1UsuContri'])->execute()->getFirst();
                    $url= 'http://dueling.xerintel.net/versus/'.$reg->id;

                    $mail_de="hola@dueling.es";
            		$mail_para= $mailDestinatario->email;
                    $nombreReto = $reg->title_es;


                    include("mails/1vs1ContrincanteCorreo.php");


                    }elseif($_POST['1vs1EquiContri']){

                    /*$reg->idContrincante=$_POST['1vs1EquiContri'];*/
                    $url= 'http://dueling.xerintel.net/versus/'.$reg->id;

                    $equipoAenviar= Doctrine_Query::create()->from('Equipo')->where('id = ?', $_POST['1vs1EquiContri'])->execute()->getFirst();
                    $mailDestinatario1= Doctrine_Query::create()->from('UserWeb')->where('id = ?', $equipoAenviar->idCreador)->execute()->getFirst();

                    $mail_de="hola@dueling.es";
            		$mail_para= $mailDestinatario1->email;
                    $nombreReto = $reg->title_es;

            		include("mails/1vs1EquipoCorreo.php");

                    }


                if(count($_POST['colectivoUsuariosArray'])>0){

                $url= 'http://dueling.xerintel.net/versus/'.$reg->id;

                $asunto_mail = '¡Te han retado!';

                $body_mail ='¡Te han retado a un duelo!<br/><br/><br/><br/>
						Si quieres aceptarlo pincha aquí para unirte: '.$url.'';

                $arrays = $_POST['colectivoUsuariosArray'];
                foreach ($arrays as $array) {

                $user= Doctrine_Query::create()->from('UserWeb')->where('id = ?', $array)->execute()->getFirst();

                $reg2 = new CronCorreoRetarColectivos();
                $reg2->mailPara=$user->email;
                $reg2->mail_de=$_SESSION['userWeb']['email'];
                $reg2->body_mail=$body_mail;
                $reg2->asunto_mail=$asunto_mail;
                $reg2->createdAt = date("Y-m-d H:i:s");
                $reg2->nombreReto = $reg->title_es;
                $reg2->urlReto = $url;
                $reg2->save();
                }
                }elseif(count($_POST['colectivoEquiposArray'])>0){

                                $url= 'http://dueling.xerintel.net/versus/'.$reg->id;

                $asunto_mail = '¡Han retado a tu equipo!';

                $body_mail ='¡A tu equipo le han retado a duelo!<br/><br/><br/><br/>
						Si quieres aceptarlo pincha aquí para unirte: '.$url.'';

                //error_log(print_r( $_POST['colectivoEquiposArray'], true));

                $arrays1 = $_POST['colectivoEquiposArray'];
                //error_log(print_r($arrays1, true));
                foreach ($arrays1 as $array1) {

                $equipo= Doctrine_Query::create()->from('Equipo')->where('id = ?', $array1)->execute()->getFirst();

                //error_log("id".$equipo->id);

                $userCreador= Doctrine_Query::create()->from('UserWeb')->where('id = ?', $equipo->idCreador)->execute()->getFirst();

                $reg4 = new CronCorreoRetarColectivos();
                //error_log("idUserCreador".$userCreador->id);
                //error_log($userCreador->email);
                $reg4->mailPara=$userCreador->email;
                $reg4->mail_de=$_SESSION['userWeb']['email'];
                $reg4->body_mail=$body_mail;
                $reg4->createdAt = date("Y-m-d H:i:s");
                $reg4->asunto_mail=$asunto_mail;
                $reg4->nombreReto = $reg->title_es;
                $reg4->urlReto = $url;
                $reg4->save();
                }
                }else{

                }





                /*$reg3= Doctrine_Query::create()->delete('EquipoConex')->where('idEquipo = ?',$_POST['id'])->execute();



                $arrays = $_POST['usuariosEquipo'];
                foreach ($arrays as $array) {

                        $reg2 = new EquipoConex();
                        $reg2->idUsuarioWeb=$array;
                        $reg2->idEquipo=$reg->id;
                        $reg2->save();

                }*/

        		$errorEditarReto=2;
        		}
        		catch(Exception $e)
        		{
        			error_log("Error al modificar : " . $e);
        			$errorEditarReto=3;
        		}
        	}



        if(isset($_POST['btnBorrarReto']))
        {

        $reg= Doctrine_Query::create()->delete('Reto')->where('id = ?',$_POST['id'])->execute();

        try
		{

        $reg2= Doctrine_Query::create()->delete('RetoConex')->where('idReto = ?',$_POST['id'])->execute();

        }
		catch(Exception $e)
		{
			error_log("Error al modificar : " . $e);

		}}





if (isset($_POST['btnInscribirOponente']))
{
    $reg= Doctrine_Query::create()->from('Reto')->where('id = ?',$_POST['idReto'])->execute()->getFirst();
    $reg->idContrincante= $_SESSION['userWeb']['id'];
    $reg->save();
    $url= 'http://dueling.xerintel.net/versus/'.$reg->id;

        $yaHay= Doctrine_Query::create()->from('RelacionPrimariaReto')->where('idReto = ?', $reg->id)->andWhere('idUsuario = ?', $_SESSION['userWeb']['id'])->execute()->getFirst();

    if($yaHay)
    {

    }
    else
    {
            $reg5 = new RelacionPrimariaReto();
            $reg5->idUsuario = $_SESSION['userWeb']['id'];
            $reg5->idReto = $reg->id;
            $reg5->save();
    }


?>
	<script>
		setTimeout(function(){ window.location = "<?=$url?>"; }, 500);
	</script>
	<?php
    }


if (isset($_POST['btnInscribirRetador']))
{
    $reg= Doctrine_Query::create()->from('Reto')->where('id = ?',$_POST['idReto'])->execute()->getFirst();
    $reg->idRetador= $_SESSION['userWeb']['id'];
    $reg->save();
    $url= 'http://dueling.xerintel.net/versus/'.$reg->id;

    $yaHay= Doctrine_Query::create()->from('RelacionPrimariaReto')->where('idReto = ?', $reg->id)->andWhere('idUsuario = ?', $_SESSION['userWeb']['id'])->execute()->getFirst();

    if($yaHay)
    {

    }
    else
    {
            $reg5= new RelacionPrimariaReto();
            $reg5->idUsuario = $_SESSION['userWeb']['id'];
            $reg5->idReto = $reg->id;
            $reg5->save();
    }
?>
	<script>
		setTimeout(function(){ window.location = "<?=$url?>"; }, 500);
	</script>
	<?php
    }

    if (isset($_POST['btnInscribirRetadorEquipo']))
{
    $reg= Doctrine_Query::create()->from('Reto')->where('id = ?',$_POST['idReto'])->execute()->getFirst();
    $reg->idRetador= $_POST['equipoRetador'];
    $reg->save();
    $url= 'http://dueling.xerintel.net/versus/'.$reg->id;


        $integrantesEquipo= Doctrine_Query::create()->from('EquipoConex')->where('idEquipo = ?', $reg->idRetador)->execute();

            foreach($integrantesEquipo as $integranteEquipo){

    $yaHay= Doctrine_Query::create()->from('RelacionPrimariaReto')->where('idReto = ?', $reg->id)->andWhere('idUsuario = ?', $integranteEquipo->idUsuarioWeb)->execute()->getFirst();

                if($yaHay)
                {

                }
                else
                {

                    $reg5 = new RelacionPrimariaReto();
                    $reg5->idUsuario = $integranteEquipo->idUsuarioWeb;
                    $reg5->idReto = $reg->id;
                    $reg5->save();

                }
    }


?>
	<script>
		setTimeout(function(){ window.location = "<?=$url?>"; }, 500);
	</script>
	<?php
    }

    if (isset($_POST['btnInscribirOponenteEquipo']))
{
    $reg= Doctrine_Query::create()->from('Reto')->where('id = ?',$_POST['idReto'])->execute()->getFirst();
    $reg->idContrincante= $_POST['equipoOponente'];
    $reg->save();
    $url= 'http://dueling.xerintel.net/versus/'.$reg->id;


     $integrantesEquipo= Doctrine_Query::create()->from('EquipoConex')->where('idEquipo = ?', $reg->idContrincante)->execute();

            foreach($integrantesEquipo as $integranteEquipo){

    $yaHay= Doctrine_Query::create()->from('RelacionPrimariaReto')->where('idReto = ?', $reg->id)->andWhere('idUsuario = ?', $integranteEquipo->idUsuarioWeb)->execute()->getFirst();

                if($yaHay)
                {

                }
                else
                {

                    $reg5 = new RelacionPrimariaReto();
                    $reg5->idUsuario = $integranteEquipo->idUsuarioWeb;
                    $reg5->idReto = $reg->id;
                    $reg5->save();

                }
    }
?>
	<script>
		setTimeout(function(){ window.location = "<?=$url?>"; }, 500);
	</script>
	<?php
    }


if (isset($_POST['btnInscribirParticipanteColectivoIndividual']))
{
    $reg = new RetoConex();
    $reg->idUsuarioWeb= $_SESSION['userWeb']['id'];
    $reg->idReto= $_POST['idReto'];
    $reg->save();
    $url= 'http://dueling.xerintel.net/versus/'.$_POST['idReto'];
    //error_log($_POST['idReto']);
    $yaHay= Doctrine_Query::create()->from('RelacionPrimariaReto')->where('idReto = ?', $_POST['idReto'])->andWhere('idUsuario = ?', $_SESSION['userWeb']['id'])->execute()->getFirst();

    if($yaHay)
    {

    }
    else
    {
            $reg5= new RelacionPrimariaReto();
            $reg5->idUsuario = $_SESSION['userWeb']['id'];
            $reg5->idReto = $_POST['idReto'];
            $reg5->save();
    }
?>
	<script>
		setTimeout(function(){ window.location = "<?=$url?>"; }, 500);
	</script>
	<?php
    }



    if (isset($_POST['btnInscribirParticipanteColectivoEquipo']))
{
    $reg = new RetoConex();
    $reg->idEquipo= $_POST['equipoParticipante'];
    $reg->idReto= $_POST['idReto'];
    $reg->save();
    $url= 'http://dueling.xerintel.net/versus/'.$_POST['idReto'];




        $integrantesEquipo= Doctrine_Query::create()->from('EquipoConex')->where('idEquipo = ?',$reg->idEquipo)->execute();

            foreach($integrantesEquipo as $integranteEquipo){

    $yaHay= Doctrine_Query::create()->from('RelacionPrimariaReto')->where('idReto = ?', $_POST['idReto'])->andWhere('idUsuario = ?', $integranteEquipo->idUsuarioWeb)->execute()->getFirst();

                if($yaHay)
                {

                }
                else
                {

                    $reg5 = new RelacionPrimariaReto();
                    $reg5->idUsuario = $integranteEquipo->idUsuarioWeb;
                    $reg5->idReto = $_POST['idReto'];
                    $reg5->save();

                }

            }

?>
	<script>
		setTimeout(function(){ window.location = "<?=$url?>"; }, 500);
	</script>
	<?php
    }





    if(isset($_GET['logout']) && $_GET['logout']==1)
    {

	unset($_SESSION['userWeb']);
	?>
	<script>
		setTimeout(function(){ window.location = "home"; }, 500);
	</script>

	<?php
    }
?>
