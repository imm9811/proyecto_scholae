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

  $idPlataforma=$_GET['id'];
  $plataforma = Doctrine_Query::create()->from('Plataformas')
  ->where("id = ?", $idPlataforma)
  ->execute()
  ->getFirst();


?>
<div class="editarFormulario ocultar">
<h2>Editar Plataforma</h2>
<div class="table-responsive">
    <form role="form" action="../lib/api.php" class="formulario" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="apiMethod" value="setPlataformas">
        <input type="hidden" name="id" value="<?php echo $plataforma->id ?>">
        <input type="hidden" name="apiMethod" value="setPlataformas">
        <label class="formulario__label">Nombre</label>
        <input type="text" name="titulo" value="<?php echo $plataforma->titulo ?>" required  class="formulario__input">

        <label class="formulario__label">Foto*</label>
        <input type="file" name="file" value="<?php echo $plataforma->foto ?>" required  class="formulario__input">
        <label class="formulario__label">Enlace</label>
        <input type="text" name="enlace" value="<?php echo $plataforma->id ?>" required class="formulario__input">
        <p>*Por cuestiones de privacidad HTML no permite asignar valores a los campos tipo file, así que hay que seleccionar un archivo obligatoriamente</p>
        <button id="enviar" class="btn btn-primary"> Añadir </button>
    </form>
</div>
</div>

<?php include '../site_footer.php';   ?>