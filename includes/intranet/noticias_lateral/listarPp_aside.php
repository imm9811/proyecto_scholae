<style>
#enviar{
  width: 160px;
  position: relative;
  left: 40%; 
  bottom: 300px;
  height: 70px;
}
</style>
<h2>Listado de Noticias laterales</h2>
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
          <th>Modificar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>
          
      <?php $arrayNoticias = Doctrine_Query::create()->from('Noticias')
          ->execute();
          $longArray =count($arrayNoticias);
          if ($longArray!=0) {

          foreach ($arrayNoticias as $noticia) {
            $ubicacion="../../assets/images/$noticia->foto";
            echo "
                        
                        <tr>
                          <td>$noticia->id</td>
                          <td>$noticia->titulo</td>
                          <td>$noticia->descripcion</td>
                          ";
                       /*
                        <td><img src='$ubicacion'></td>*/
               echo "
                          <td>$noticia->descripcion</td>
                          <td><a href='index.php?page=mod&id=$noticia->id&pertenece=Pp_aside'><span class='glyphicon-edit'>&#x270f;</span></a></td>";
            ?>
            <td><button class='glyphicon-remove' onclick="return delete_post(<?php echo $noticia->id ?>, 'Noticias')"><span>X</span></button></td>
            <?php "
                      </tr>
                      ";
          }
        }else{
          echo "<tr>
          <td colspan='7'>no hay valores</td>
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