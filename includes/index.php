<?php
include "plantilla.php";
$page = $_GET["page"];
switch ($page) {
	case 'login':
		header("location: login-register.php");
		//header('location: intranet/index.php?page=plataforma');
		break;
	case 'home':
		header("location: index.html");
		break;
	case 'plataformas':
		//header("location: ../plataformas.html");
		include "plataforma.php";
		include "include/site_footer.php";
		break;
	case 'panel':
		//header("location: ../plataformas.html");
		include "../panel.html";
		break;

	case 'contacto':
		include 'contacto.php';
		include "include/site_footer.php";
		break;

	case 'checkin':
		//echo "entro";
		if (isset($_POST['user'])) {
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
						window.location.href = "intranet/index.php?page=plataformas";
					}
					if(data['type']=='error'){
						window.location.href = "index.php?page=home";	
					}
					
				}
			});
		</script>
	<?php

	//header("location:lib/prueba_api.php?apiMethod=login");
}
//&user=".$_POST['user']."&password=".$_POST['contraseña']."
break;
}

?>