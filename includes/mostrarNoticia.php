<div class="col-lg-9 col-sm-12 col-xs-12 texto_principal">
				<!--TEXTO PARA LAS NOTICIAS -->
				<div class="row">
					<div class="col-lg-12 text-center">
                        <?php
                        
						$arrayNoticias = Doctrine_Query::create()->select("noti.id, noti.titulo, noti.descripcion")
							->from('Noticia noti, Categoria cat')
							->where('noti.categoria_id = cat.id')
							->andWhere('cat.id = ? ',$pertenece)//variable que viene del index.php
							->execute();

						$longArray = count($arrayNoticias);
						// print_r($arrayNoticias);debug();die();echo $noticia->id;echo $noticia->descripcion;
						if ($longArray != 0) {
							foreach ($arrayNoticias as $noticia) {

								echo "
							<div class='col-lg-12 noticia'>
								<div class='col-lg-11'>
								  <h2>$noticia->titulo </h2>
								</div>
								
								<div class='col-lg-12'>
								<p class='cuerpo'>$noticia->descripcion</p>
								
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
                            echo "NO HAY NOTICIAS DE ESTA CATEGORIA";
                        }
						?>

					</div>

				</div>
			</div>