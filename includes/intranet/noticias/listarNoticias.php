<style>
  #enviar {
    width: 160px;
    position: relative;
    left: 70%;
    bottom: 600px;
    height: 70px;
  }
</style>
<h2>Listado de Noticias</h2>
<div class="table-responsive">
  <form role="form" action="" method="post" enctype="multipart/form-data">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#ID</th>
          <th>Titulo</th>
          <th>Descripcion</th>
          <th>Fotos</th>
          <th>Archivos</th>
          <th>Categoría</th>
          <th>Modificar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>

        <?php
        $arrayFormatosImagenes= ["jpeg","jpg","png","gif","tiff","raw","bmw","svg"];
        
        /*$arrayNoticias = Doctrine_Query::create()->from('Noticia')
          ->execute();*/
        /*$arrayNoticias = Doctrine_Query::create()->from('Noticia not, Multimedia mul, Categoria cat')
                                                ->where('not.multimedia_id = mul.id')
                                                ->andWhere('not.id = cat.noticia_id')
                                                ->execute();
                                                SELECT * FROM multimedia, noticia where multimedia.noticia_id = noticia.id
         select noti.id, noti.titulo, noti.descripcion, mul.url from noticia as noti, multimedia as mul, categoria as cat where noti.id = mul.noticia_id and noti.id = cat.noticia_id
         select noti.titulo, noti.descripcion from noticia as noti, categoria as cat where noti.id = cat.noticia_id
         SELECT url FROM `multimedia` where noticia_id = $id

          $consultaNoticias=consultade arriba
          while(consultaNoticias->fetch(PDO::FETCH_ASSOC)){

            $id= $fetch['id'];
            $titulo= $fetch['titulo'];
            $descripcion= $fetch['descripcion'];
  $mysqli = new mysqli("127.0.0.1", "root", "", "scholae");
          $mysqli->query("select not.titulo")

          }
select noti.titulo, noti.descripcion from noticia as noti, categoria as cat where noti.id = cat.noticia_id
          */
        $arrayNoticias = Doctrine_Query::create()->select("noti.id, noti.titulo, noti.descripcion")
          ->from('Noticia noti, Categoria cat')
          ->where('noti.categoria_id = cat.id')
          ->execute();


        $longArray = count($arrayNoticias);
        
        if ($longArray != 0) {
          foreach ($arrayNoticias as $noticia) {
           
           
            echo "
                        <tr>
                          <td>$noticia->id</td>
                          <td>$noticia->titulo</td>
                          <td>$noticia->descripcion</td>
                          ";
                       
                        

            if (isset($noticia->multimedia_id)) {
              echo "<td>";
              $arrayArchivos = Doctrine_Query::create()
                ->from('Multimedia')
                ->where("noticia_id = $noticia->id")
                ->execute();
                
                foreach($arrayArchivos as $archivos){
                 
                  if(!is_null($archivos->url)){
                    $archivo = explode(".",$archivos->url);
                    $ubicacion="../../assets/images/$archivos->url";
                    //$formato=array_search($archivo,$arrayFormatosImagenes)==true;
                    foreach($arrayFormatosImagenes as $formatos){
                      if(!$archivo){
                        if($archivo == $formatos){
                           echo " <img src='$ubicacion'> ";
                        }else{
                          echo "<a href='$ubicacion' download>$archivos->url</a>";
                        }
                       
                      }else{
                        echo "aqui van los videos";
                      }
                    }
                   
                    
                  }
                  /*AQUI TENGO QUE DECLARAR UNA VARIABLE MAS PARA PODER INTRODUCIR VIDEOS
                  if(strpos($archivo,'youtube')){
                    echo $archivos->url."<iframe width='560' height='315' src='$archivos->url' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
                  }
                  */
                 
                } 
                echo "</td>";
             }else{
              echo "<td colspan='2'>sin multimedia</td>";
            }
            $nombreCategoria = Doctrine_Query::create()
            ->select('nombre')
            ->from('Categoria')
            ->where("id = $noticia->categoria_id")
            ->execute()
            ->getFirst();
               echo "
                          <td></td>
                          <td>$nombreCategoria->nombre</td>
                          <td><a href='index.php?page=mod&id=$noticia->id&pertenece=Noticias'><span class='glyphicon-edit'>&#x270f;</span></a></td>";
            ?>
        <td><button class='glyphicon-remove' onclick="return delete_post(<?php echo $noticia->id ?>, 'Noticias')"><span>X</span></button></td>
        <?php "
                      </tr>
                      ";
          }
        }else{
          echo "<tr>
          <td colspan='8'>no hay valores</td>
          </tr>";
        }

        ?>
      </tbody>
    </table>
  </form>
  <br />
  <br />
  <br />
  <br />
</div>
<?php include '../site_footer.php';   ?>