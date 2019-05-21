<script>
$(document).ready(function(){
   $(".listar").removeClass("mostrar");
   $(".añadir").removeClass("mostrar");
   $(".listar").addClass("ocultar");
   $(".añadir").addClass("ocultar");
    $(".editarFormulario").removeClass("ocultar");
    $(".editarFormulario").removeClass("mostrar");
});
</script>
<?php
$saludo=$_GET['id'];

  $idCate=$_GET['id'];
  $cate = Doctrine_Query::create()->from('Categorias')
  ->where("id = ?", $idCate)
  ->execute()
  ->getFirst();


?>
<div class="editarFormulario ocultar">
<h2>Editar Categoría</h2>
<div class="table-responsive">
    <form role="form" action="../lib/api.php" class="formulario" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="apiMethod" value="setCategoria">
        <input type="hidden" name="id" value="<?php echo $cate->id ?>">
        <label class="formulario__label">Nombre</label>
        <input type="text" name="usuario" value="<?php echo $cate->nombre ?>" class="formulario__input">

        <button id="enviar" class="btn btn-primary"> Añadir </button>
    </form>
</div>
</div>

<?php include '../site_footer.php';   ?>