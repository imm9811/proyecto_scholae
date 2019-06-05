<?php

$page = $_GET["page"];
switch ($page) {
	case 'login':
		header("location: login-register.php");
		break;
	case 'home':
		
		include "indice.php";
	break;
	case 'plataformas':
		include "plantilla.php";
		//header("location: ../plataformas.html");
		include "plataforma.php";
		include "include/site_footer.php";
		break;

	case 'panel':
	include "plantilla.php";
		//header("location: ../plataformas.html");
		include "../panel.html";
		break;

	case 'contacto':
	include "plantilla.php";
		include 'contacto.php';
		include "include/site_footer.php";
		break;
	
	case 'Noticia':
		$pertenece=$_GET['pertenece'];
		include "plantilla.php";
		include "mostrarNoticia.php";	
		include "include/site_footer.php";
	break;
	
			case 'checkin':
	include "plantilla.php";
		//echo "entro";
		if (isset($_POST['user']) and isset($_POST['contraseña'])  ) {
			//echo "dentro del if";
			$usuario = $_POST['user'];
			$contrasena = $_POST['contraseña'];
			 
			?>
		<script> 

			 $.ajax({
				url: "lib/api.php",
				method: "post",
				data: { apiMethod: 'login', usuario: '<?php echo $usuario ?>', contrasena: '<?php echo $contrasena ?>' },
				success: function (data) {
					console.log(data);
					if(data['type']=='ok'){
						console.log(data);
						window.location.href = "intranet/index.php?page=Noticias";
					}
					if(data['type']=='error'){
						window.location.href = "index.php?page=login";	
					}
					
				}
			});
		</script>
	<?php
}

break;
}

?>