<style>
#enviar{
  width: 160px;
  position: relative;
  left: 440px; 
  bottom: 80px;
  height: 70px;
}
</style>
<h2>Listado de Categorías</h2>
<div class="table-responsive">
  <form role="form" action="" method="post" enctype="multipart/form-data">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#ID</th>
          <th>Categoría</th>
          <th>Modificar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>

        <?php $arrayCategorias = Doctrine_Query::create()->from('Categoria')
          ->execute();
          $longArray =count($arrayCategorias);
         
          if ($longArray!=0) {

            foreach ($arrayCategorias as $categoria) {
              //echo "$administrador->nombre $administrador->id";
             if($categoria->id==1 || $categoria->id==2){
              echo "
                          
              <tr>
                <td>$categoria->id</td>
                <td>$categoria->nombre</td>
                <td><a href='index.php?page=mod&id=$categoria->id&pertenece=Categorias'><span class='glyphicon-edit'>&#x270f;</span></a></td>";
              ?>
              <td></td>
              <?php "
            </tr>
            ";
             }else{

                
                  echo "
                              
                              <tr>
                                <td>$categoria->id</td>
                                <td>$categoria->nombre</td>
                                <td><a href='index.php?page=mod&id=$categoria->id&pertenece=Categorias'><span class='glyphicon-edit'>&#x270f;</span></a></td>";
                  ?>
                  <td><button class='glyphicon-remove' onclick="return delete_post(<?php echo $categoria->id ?>, 'Categoria')"><span>X</span></button></td>
                  <?php "
                            </tr>
                            ";
              }
            }
          }else{
            echo " <tr>
            <td colspan='4'> No hay categorias </td>";
          }

        ?>
      </tbody>
    </table>
  </form>

</div>
<?php include '../site_footer.php';   ?>