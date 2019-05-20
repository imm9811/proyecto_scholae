<h2>Listado de Administradores</h2>
<div class="table-responsive">
  <form role="form" action="" method="post" enctype="multipart/form-data">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#ID</th>
          <th>Nombre</th>
          <th>Apellidos</th>
          <th>Username</th>
          <th>Correo</th>
          <th>Modificar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>

        <?php $arrayAdministradores = Doctrine_Query::create()->from('Administradores')
          ->execute();
          $longArray =count($arrayAdministradores);
          if ($longArray!=0 || !empty($arrayAdministradores)) {

          foreach ($arrayAdministradores as $administrador) {
            //echo "$administrador->nombre $administrador->id";
            echo "
                        
                        <tr>
                          <td>$administrador->id</td>
                          <td>$administrador->nombre</td>
                          <td>$administrador->apellidos</td>
                          <td>$administrador->username</td>
                          <td>$administrador->correo</td>
                          <td><a href='index.php?page=modAdmin&id=$administrador->id'><span class='glyphicon-edit'>&#x270f;</span></a></td>";
            ?>
            <td><button class='glyphicon-remove' onclick="return delete_post(<?php echo $administrador->id ?>, 'Administradores')"><span>X</span></button></td>
            <?php "
                      </tr>
                      ";
          }
        }else{
          echo " <tr>
          <td colspan='6'> No hay administradores/td>";
        }

        ?>
      </tbody>
    </table>
  </form>

</div>
<?php include '../site_footer.php';   ?>