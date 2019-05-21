<style>
#enviar{
  width: 160px;
  position: relative;
  left: 85%; 
  bottom: 250px;
  height: 70px;
}
</style>
<h2>Listado de Plataformas</h2>
<div class="table-responsive">
  <form role="form" action="" method="post" enctype="multipart/form-data">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#ID</th>
          <th>Nombre</th>
          <th>Foto</th>
          <th>Enlace</th>
          <th>Modificar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>
          
      <?php $arrayPlataformas = Doctrine_Query::create()->from('Plataformas')
          ->execute();
          $longArray =count($arrayPlataformas);
          if ($longArray!=0) {

          foreach ($arrayPlataformas as $plataforma) {
            $ubicacion="../../assets/images/$plataforma->foto";
            echo "
                        
                        <tr>
                          <td>$plataforma->id</td>
                          <td>$plataforma->titulo</td>
                          <td><img src='$ubicacion'></td>
                          <td>$plataforma->descripcion</td>
                          <td><a href='index.php?page=modPlataforma&id=$plataforma->id'><span class='glyphicon-edit'>&#x270f;</span></a></td>";
            ?>
            <td><button class='glyphicon-remove' onclick="return delete_post(<?php echo $plataforma->id ?>, 'Plataformas')"><span>X</span></button></td>
            <?php "
                      </tr>
                      ";
          }
        }else{
          echo "<tr>
          <td colspan='6'>no hay valores</td>
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