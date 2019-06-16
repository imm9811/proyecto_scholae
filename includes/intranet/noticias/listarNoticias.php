<style>
  #enviar, #borrar{
    width: 160px;
    position: relative;
    left: 63%;
    
    height: 70px;
  }
  #enviar{
    bottom: 357px;
  }
  #borrar{
    bottom: 370px;
  }
</style>
<h2>Listado de Noticias</h2>

<div class="container">

  <?php

  $arrayNoticias = Doctrine_Query::create()->select("noti.id, noti.titulo, noti.descripcion")
    ->from('Noticia noti, Categoria cat')
    ->where('noti.categoria_id = cat.id')
    ->execute();


  $longArray = count($arrayNoticias);

  if ($longArray != 0) {
    foreach ($arrayNoticias as $noticia) {
      
    $nombreCategoria = Doctrine_Query::create()
    ->select('nombre')
    ->from('Categoria')
    ->where("id = $noticia->categoria_id")
    ->execute()
    ->getFirst();

      echo "
          <div class='row' style='margin-bottom: 10%; '>
          <div class='col-lg-10 border border-warning'>
                <div>
                    <b><u>ID</u></b>
                  </div>
                  <div >
                    $noticia->id
                  </div>
                  <div>
                    <b><u>Titulo</u></b>
                  </div>
                  <div >
                  $noticia->titulo
                  </div>
                    <div>
                    <b><u>Descripción</u></b>
                  </div>
                  <div >
                  $noticia->descripcion
                  </div>
                  <div>
                    <b><u>Categoría</u></b>
                  </div>
                  <div>
                    $nombreCategoria->nombre
                  </div>
                 ";


      $arrayArchivos = Doctrine_Query::create()
        ->from('Multimedia')
        ->where("noticia_id = $noticia->id")
        ->execute();

      

      if (!empty($arrayArchivos)) {
        if(count($arrayArchivos) > 0)
        {
            echo "
          <div>
          <b><u>Foto</u></b>
          </div>";
        }
        //bucle para mostrar todas las fotos
        foreach ($arrayArchivos as $archivos) {
          if($archivos->eliminado==0){ 
          $esArchivo = strpos($archivos->url, ".");

          $ubicacion = "../../assets/images/$archivos->url";
          $archivo = $archivos->url;

            if ($esArchivo == true) {

              foreach ($arrayFormatosImagenes as $formato) {

                if (strpos($archivo, $formato)) {
                  echo " 
                
                    <div>
                    <img width='25%' src='$ubicacion'> 
                    </div>
                ";
                } 
              }
            }
          } 
        }
          echo "
          <div>
          <b><u>Video</u></b>
          </div>";

          foreach ($arrayArchivos as $archivos) {

              $esArchivo = strpos($archivos->url, ".");

              $ubicacion = "../../../assets/images/$archivos->url";
              $archivo = $archivos->url;            

                //condicion para saber si esta metiendo un video
                if ($esArchivo == false && $archivo != null) {
                  echo " 
                    <div>
                    $archivos->url
                    </div>
                ";
                }
              
            
          }
          echo "
          <div>
          <b><u>Descargable</u></b>
          </div>";

          foreach ($arrayArchivos as $archivos) {
            if($archivos->eliminado==0){ 
              $esArchivo = strpos($archivos->url, ".");

              $ubicacion = "../../../assets/images/$archivos->url";
              $archivo = $archivos->url;

              foreach ($arrayFormatosTextos as $formato) {
                if (strpos($archivo, $formato)) {
                  echo " 
                  
                      <div>
                      <a href='$ubicacion' download>$archivos->url</a>
                      </div>
                  ";
                }
              }
            }
          }
      } else {
        echo "no hay contenido multimedia";
      }

      echo "
              </div>

          <div class='col-lg-2 ' style='text-align:center'>
            <div class='col-lg-12  border border-info' style='margin-bottom:60%'><div><a href='index.php?page=mod&id=$noticia->id&pertenece=Noticias'>Modificar<span class='glyphicon-edit'>&#x270f;</span></a></div></div>
            ";
      ?>
      <div class='col-lg-12  border border-danger'>Eliminar
        <div>
          <button class='glyphicon-remove' onclick="return delete_post('<?php echo $noticia->id ?>', 'Noticia')"><span>X</span></button>
        </div>
      </div>
      <?php
      echo "
          </div>
        </div>
          ";
    }
  } else {
    echo "no hay Noticia";
  }
  ?>

</div>

<?php include '../site_footer.php';   ?>