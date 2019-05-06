<?php
include "../plantilla.php";
$page=$_GET["page"];
	switch($page){
		case 'login':
			header("location: ../login-register.php");
			break;
		case 'home':
            header("location: ../index.html");
			break;
        case 'plataformas':
			//header("location: ../plataformas.html");
		   include "../plataforma.php";
		   include "site_footer.php";
		break;
		case 'panel':
            //header("location: ../plataformas.html");
           include "../panel.html";
		break;

		case 'contacto':
			include '../contacto.php';
			include "site_footer.php";
		break;
		case 'checkin':
			if(!isset($_POST['user'])){
				header("location:api.php?apiMethod='login'&user=".$_post['user']."&password=".$_post['contraseña']."");
			}
			break;
	}

?>