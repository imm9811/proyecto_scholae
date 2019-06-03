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
	<link href="../assets/cool-share/plugin.css" media="all" rel="stylesheet" />
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
						<li><a href="index.php?page=home">Home</a></li>
						<li><a href="index.php?page=plataformas">Plataformas</a></li>

					</ul>
				</nav>
			</header>

			<a class="navbar-brand" href="index.html" style="padding:0px;">
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

					<li class="nav-item">
						<a class="nav-link" href="index.php?page=contacto">Contacta</a>
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
								if ($categoria->nombre != 'Principal') {
									echo "
			  		<li><a href='index.php?page=$categoria->nombre'>$categoria->nombre</a></li>        
                ";
								}
							}
						} else {
							echo " <li> No hay categorias </li>";
						}
						?>
					</li>


				</ul>
			</nav>
			<div class="col-lg-10 col-md-10 col-xs-12 cuerpo">
				<div class="row">
					<!--SLIDER-->
					<div class="slide">
						<!--Carousel Wrapper-->
						<div id="video-carousel-example2" class="carousel slide carousel-fade" data-ride="carousel">
							<!--Indicators-->
							<ol class="carousel-indicators">
								<li data-target="#video-carousel-example2" data-slide-to="0" class="active"></li>
								<li data-target="#video-carousel-example2" data-slide-to="1"></li>
								<li data-target="#video-carousel-example2" data-slide-to="2"></li>
							</ol>
							<!--/.Indicators-->
							<!--Slides-->
							<div class="carousel-inner" role="listbox">
								<!-- First slide -->
								<div class="carousel-item active">
									<!--Mask color-->
									<div class="view">
										<!--Video source-->
										<video class="video-fluid" autoplay loop muted>
											<source src="https://mdbootstrap.com/img/video/Lines.mp4" type="video/mp4" />
										</video>
										<div class="mask rgba-indigo-light"></div>
									</div>

									<!--Caption-->
									<div class="carousel-caption">
										<div class="animated fadeInDown">
											<h3 class="h3-responsive">Light mask</h3>
											<p>First text</p>
										</div>
									</div>
									<!--Caption-->
								</div>
								<!-- /.First slide -->

								<!-- Second slide -->
								<div class="carousel-item">
									<!--Mask color-->
									<div class="view">
										<!--Video source-->
										<video class="video-fluid" autoplay loop muted>
											<source src="https://mdbootstrap.com/img/video/animation-intro.mp4" type="video/mp4" />
										</video>
										<div class="mask rgba-purple-slight"></div>
									</div>

									<!--Caption-->
									<div class="carousel-caption">
										<div class="animated fadeInDown">
											<h3 class="h3-responsive">Super light mask</h3>
											<p>Secondary text</p>
										</div>
									</div>
									<!--Caption-->
								</div>
								<!-- /.Second slide -->

								<!-- Third slide -->
								<div class="carousel-item">
									<!--Mask color-->
									<div class="view">
										<!--Video source-->
										<video class="video-fluid" autoplay loop muted>
											<source src="https://mdbootstrap.com/img/video/Tropical.mp4" type="video/mp4" />
										</video>
										<div class="mask rgba-black-strong"></div>
									</div>

									<!--Caption-->
									<div class="carousel-caption">
										<div class="animated fadeInDown">
											<h3 class="h3-responsive">Strong mask</h3>
											<p>Third text</p>
										</div>
									</div>
									<!--Caption-->
								</div>
								<!-- /.Third slide -->
							</div>
							<!--/.Slides-->
							<!--Controls-->
							<a class="carousel-control-prev" href="#video-carousel-example2" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#video-carousel-example2" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
							<!--/.Controls-->
						</div>
						<!--Carousel Wrapper-->

						<!--fin slider-->
					</div>
				</div>
			</div>

			<!--Carousel Wrapper-->
			<div class="col-lg-9 col-sm-12 col-xs-12 texto_principal">
				<!--TEXTO PARA LAS NOTICIAS -->
				<div class="row">
					<div class="col-lg-12 text-center">
						<?php
						$arrayFormatosImagenes = ["jpeg", "jpg", "png", "gif", "tiff", "raw", "bmw", "svg"];
						$arrayFormatosTextos= ["pdf","txt","doc","html","docx","zip","rar","xlsx"];
						$arrayNoticias = Doctrine_Query::create()->select("noti.id, noti.titulo, noti.descripcion")
							->from('Noticia noti, Categoria cat')
							->where('noti.categoria_id = cat.id')
							->andWhere('cat.id=1 ')
							->execute();

						$longArray = count($arrayNoticias);
						// print_r($arrayNoticias);debug();die();echo $noticia->id;echo $noticia->descripcion;
						if ($longArray != 0) {
							foreach ($arrayNoticias as $noticia) {

								echo "
                        
                          <h2>$noticia->titulo</h2>
						  <div>
						  <p>$noticia->descripcion</p>
						  
                          ";
								$arrayArchivos = Doctrine_Query::create()
									->from('Multimedia')
									->where("noticia_id = $noticia->id")
									->execute();
								if (!empty($arrayArchivos)) {
									//bucle para mostrar todas las fotos
									foreach ($arrayArchivos as $archivos) {

										$esArchivo = strpos($archivos->url, ".");

										$ubicacion = "../assets/images/$archivos->url";
										$archivo = $archivos->url;
										if ($esArchivo == true) {
											foreach ($arrayFormatosImagenes as $formato) {
												if (strpos($archivo,$formato)) {
													echo " <p><img width='65%' src='$ubicacion'> </p>";
												}	
											}
											foreach ($arrayFormatosTextos as $formato) {
												if (strpos($archivo,$formato)) {
													echo "<p>aqui van los archivo descargables <a href='$ubicacion' download>$archivos->url</a></p>";
												}
												
											}
											
										}
										if($esArchivo == false && $archivo !=null){
											echo "<div class='video'><iframe width='560' height='315' src='https://www.youtube.com/embed/yda62tNSLsQ' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe></div>";;
										}

									}
									//bucle para mostrar todas los archivos
									foreach ($arrayArchivos as $archivos) {

										$archivo = strpos($archivos->url, ".");
										if ($archivo == false) {
										}
									}
								} else {
									echo " ";
								}

								echo "</div>";
							} //fin del primer bucle
						} //fin iflongArray
						?>

					</div>

				</div>
			</div>
			<!--ASIDE-->
			<div class="col-lg-2 col-sm-12 col-xs-12 aside">
				aqui con los row se generaran las los aside asdasdasdasqui con los row se generaran las los
				aside
				asdasdasdas
			</div>
		</div>
	</div>
	<?php include 'include/site_footer.php'; ?>