<?php
include 'plantilla.php';
$page=$_GET["page"];
	switch($page){

		case 'home':
      		header("location: ../../indice.php");
		break;
		case 'Noticias':
		include 'noticias/ctlNoticias.php';
		//include 'panel.html';
	break;

	case 'Noticias_lateral':
		include 'noticias_lateral/ctlPp_aside.php';
			//include 'panel.html';
		break;
		case 'Plataformas':
			include 'plataformas/ctlPlataformas.php';
			//include 'panel.html';
		break;
	
		case 'Categorias':
			include 'categorias/ctlCategorias.php';
			//include 'panel.html';
		break;
		case 'Administradores':
			include 'administradores/ctlAdministradores.php';
			//include 'panel.html';
		break;
		

		/*case 'fg':
			$id=$_GET['id'];
			include 'administradores/ctlAdministradores.php';
			include "administradores/editAdministradores.php";
		break;

		case 'modPlataforma':
			$id=$_GET['id'];
			include 'plataformas/ctlPlataformas.php';
			include "plataformas/editPlataformas.php";
		break;*/
		case 'mod':
			$id=$_GET['id'];
			$pertenece=$_GET['pertenece'];
			$min=strtolower($pertenece);
			include "$min/ctl$pertenece.php";
			include "$min/edit$pertenece.php";
		break;
}
?>
