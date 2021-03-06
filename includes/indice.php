<?php
include "plantilla.php";
?>
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
											<h3 class="h3-responsive">Ejemplo 1</h3>
											<p>Ejemplo 1</p>
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
											<h3 class="h3-responsive">Ejemplo 2</h3>
											<p>Ejemplo 2</p>
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
											<h3 class="h3-responsive">Ejemplo 3</h3>
											<p>Ejemplo 3</p>
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
						$arrayNoticias = Doctrine_Query::create()->select("noti.id, noti.titulo, noti.descripcion")
							->from('Noticia noti, Categoria cat')
							->where('noti.categoria_id = cat.id')
							->andWhere('cat.id=1 ')
							->orderBy('noti.id DESC')
							->execute();

						$longArray = count($arrayNoticias);
						// print_r($arrayNoticias);debug();die();echo $noticia->id;echo $noticia->descripcion;
						if ($longArray != 0) {
							foreach ($arrayNoticias as $noticia) {

						echo "
                        	<div class='noticia'>
                          <h2>$noticia->titulo </h2>
						  <div>
						  <p>$noticia->descripcion</p>
						  
                          ";
								$arrayArchivos = Doctrine_Query::create()
									->from('Multimedia')
									->where("noticia_id = $noticia->id")
									->execute();
								if (!empty($arrayArchivos)) 
								{
									foreach ($arrayArchivos as $archivo) 
									{
										if($archivo->eliminado==0){ 
											$aArchivo = explode(".", $archivo->url);

											$ubicacion = "../assets/images/$archivo->url";
											if(isset($aArchivo[count($aArchivo)-1]) && count($aArchivo) > 1)
											{
												$codigoExtension = 0;
												$check = false;
												for($i = 0;$i < count($arrayFormatosImagenes) && 
												$check == false;$i++)
												{
													if($arrayFormatosImagenes[$i] == $aArchivo[count($aArchivo)-1])
													{
														$codigoExtension = 0;
														$check = true; 
													}
												}

												for($j = 0;$j < count($arrayFormatosTextos) && 
												$check == false;$j++)
												{
													if($arrayFormatosTextos[$j] == $aArchivo[count($aArchivo)-1])
													{
														$codigoExtension = 1;
														$check = true; 
													}
												}

												switch($codigoExtension)
												{
													case 0:
													echo " <p><img width='300px' src='$ubicacion'> </p>";
													break;

													case 1:
													echo "<p> <a href='$ubicacion' download>$archivos->url</a></p>";
													break;
												}
											}
											else{
												if($archivo->url !=""){
													echo "<div class='video'><iframe src='https://www.youtube.com/embed/$archivo->url' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe></div>";
										
												}
												
											}
										}
									}
									
								} else {
									echo " ";
								}
							
								echo "</div></div>";
							} //fin del primer bucle
						} //fin iflongArray
						?>

					</div>

				</div>
			</div>
		
			<!--ASIDE-->
			<div class="col-lg-2 col-sm-12 col-xs-12 aside">
			<?php
						$arrayNoticias = Doctrine_Query::create()->select("noti.id, noti.titulo, noti.descripcion")
							->from('Noticia noti, Categoria cat')
							->where('noti.categoria_id = cat.id')
							->andWhere('cat.id=2 ')
							->execute();

						$longArray = count($arrayNoticias);
						// print_r($arrayNoticias);debug();die();echo $noticia->id;echo $noticia->descripcion;
						if ($longArray != 0) {
							foreach ($arrayNoticias as $noticia) {

								echo "
                        	<div class='noticia'>
                          <h2 id='$noticia->id'>$noticia->titulo </h2> 
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
													echo "<p> <a href='$ubicacion' download>$archivos->url</a></p>";
												}
												
											}
											
										}
										if($esArchivo == false && $archivo !=null){
											echo "<div class='video'><iframe src='https://www.youtube.com/embed/yda62tNSLsQ' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe></div>";;
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

								echo "</div></div>";
							} //fin del primer bucle
						} //fin iflongArray
						else{
							echo "Sin noticias laterales";
						}
						?>

			</div>
		</div>
	</div>
	<?php include 'include/site_footer.php'; ?>