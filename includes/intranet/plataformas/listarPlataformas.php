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
          
      <?php 
          $arrayPlataformas = Doctrine_Query::create()->from('Plataformas')
          ->execute();
         
          foreach ($arrayPlataformas as $plataforma) {
            //echo "$administrador->nombre $administrador->id";
           
                        
                        echo " <tr>
                          <td>$plataforma->id</td>
                          <td>$plataforma->titulo</td>
                          <td>$plataforma->foto</td>
                          <td>$plataforma->descripcion</td>
                          <td><a href='index.php?page=modPlataformas&id=$plataforma->id'><span class='glyphicon-edit'>&#x270f;</span></a></td>";
            ?>
            <td><button class='glyphicon-remove' onclick="return delete_post(<?php echo $plataforma->id ?>, 'Administradores')"><span>X</span></button></td>
            <?php "
                      </tr>
                      ";
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