<?php
include 'plantilla.php';
$page=$_GET["page"];
	switch($page){

		case 'home':
            	header("location: index.html");
		break;

		case 'plataformas':
			include 'plataformas/ctlPlataforma.php';
			//include 'panel.html';
		break;
		case 'noticias':
			include 'listarPlataformas.php';
			//include 'panel.html';
		break;
		case 'noticias_lateral':
			include 'listarPlataformas.php';
			//include 'panel.html';
		break;
		case 'plataformas':
			include 'listarPlataformas.php';
			//include 'panel.html';
		break;
    }

?>