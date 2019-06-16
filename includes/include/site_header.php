<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-139763291-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'UA-139763291-1');
	</script>

	<!-- Google Tag Manager -->
	<script>
		(function(w, d, s, l, i) {
			w[l] = w[l] || [];
			w[l].push({
				'gtm.start': new Date().getTime(),
				event: 'gtm.js'
			});
			var f = d.getElementsByTagName(s)[0],
				j = d.createElement(s),
				dl = l != 'dataLayer' ? '&l=' + l : '';
			j.async = true;
			j.src =
				'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
			f.parentNode.insertBefore(j, f);
		})(window, document, 'script', 'dataLayer', 'GTM-5G2CC73');
	</script>
	<!-- End Google Tag Manager -->

	<meta charset="UTF-8">
	<title>Pagina inicial</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Official page of High School IES R.M">
	<meta property="og:title" content="Page of IES Romero Vargas" />
	<meta property="og:url" content="http://proyectocholae.tk" />
	<meta property="og:description" content="Official page of High School IES R.M">
	<meta property="og:image" content="imagenes/logo.png">
	<meta property="og:type" content="article" />
	<meta property="og:locale:alternate" content="es_ES" />
	<!--ALL with the latest version possible-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link href="../plugins/cool-share/plugin.css" media="all" rel="stylesheet" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../assets/css/temaprincipal.css">
	<script>
		var a = true;

		$(document).ready(function() {
			if ($(window).width() < 767) {}
			$(".menu-icon").click(() => {

				switch (a) {
					case true:
						a = false;
						$(".test").addClass("testFade");
						break;

					case false:
						a = true;
						setTimeout(function() {
							$(".testFade").removeClass("testFade");
						}, 500);
						break;
				}
			});
			$("#container").click(() => {
				$(".testFade").removeClass("testFade");
				if ($(".menu-toggle").prop("checked")) {
					$(".menu-icon").click();
				}
			});

		});
	</script>
</head>

<body>
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5G2CC73" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<!--Main Navigation https://codepen.io/illdapt/pen/amdQmg	https://codepen.io/web-tiki/pen/HhCyd  https://codepen.io/conorjmcnamara/pen/dLNdRo?&page=1    https://mdbootstrap.com/snippets/jquery/temp/590618?action=prism_export-->
	<!--HEADER-->
	<div>
		<?php include('lib/php/loadAll.php'); ?>
		<div class="test">
			<input type="checkbox" class="menu-toggle" id="menu-toggle">
			<div class="mobile-bar">
				<label for="menu-toggle" class="menu-icon">
					<span></span>
				</label>
			</div>

			<header class="header">
				<nav>
					<ul>
						<li><a href="index.php?page=home">Inicio</a></li>
						<li><a href="index.php?page=plataformas">Plataformas</a></li>

					</ul>
				</nav>
			</header>

			<a class="navbar-brand" href="../index.php?page=home" style="padding:0px;">
				<img alt="logo" src="https://res.cloudinary.com/candidbusiness/image/upload/v1455406304/dispute-bills-chicago.png">
			</a>

		</div>
	</div>
	<div id="container" class="container-fluid">
		<div class="row">
			<nav id="sidebar" class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
				<ul class="nav nav-pills flex-column">
					<li class="nav-item">
						<a class="nav-link active" href="#">Overview <span class="sr-only">(current)</span></a>
					</li>

					
				</ul>

				<ul class="nav nav-pills flex-column">
					<li class="nav-item">
						<?php $arrayCategorias = Doctrine_Query::create()->from('Categoria')
							->execute();
						$longArray = count($arrayCategorias);

						if ($longArray != 0) {

							foreach ($arrayCategorias as $categoria) {
								//echo "$administrador->nombre $administrador->id";
								if ($categoria->nombre != 'Principal' &&  $categoria->nombre != 'Lateral') {
									echo "
			  		<li><a href='index.php?page=Noticia&pertenece=$categoria->id'>$categoria->nombre</a></li>        
                ";
								}
							}
						} else {
							echo " <li> No hay categorias </li>";
						}
						?>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="index.php?page=contacto">Contacta</a>
					</li>

				</ul>
			</nav>