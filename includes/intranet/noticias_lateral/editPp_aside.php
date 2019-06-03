
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

  $idNoticia=$_GET['id'];
  $noticia = Doctrine_Query::create()->from('Pp_aside')
  ->where("id = ?", $idNoticia)
  ->execute()
  ->getFirst();


?>
<div class="editarFormulario ocultar">
<h2>Editar Noticia Panel Lateral</h2>
<div class="table-responsive">
    <form role="form" action="../lib/api.php" class="formulario" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="apiMethod" value="setNoticias">
        <input type="hidden" name="id" value="<?php echo $noticia->id ?>">

        <label class="formulario__label">Nombre</label>
        <input type="text" name="titulo" value="<?php echo $noticia->titulo ?>" required  class="formulario__input">

        <label class="formulario__label">Descripcion</label>
        <textarea name="descripcion"><?php echo $noticia->descripcion ?></textarea>

        <label class="formulario__label">Foto</label>

        <input type="file" name="file" required  class="formulario__input">

        <label class="formulario__label">Archivos</label>
        <input type="file" name="archivos" required class="formulario__input">
        
        <p>*Por cuestiones de privacidad HTML no permite asignar valores a los campos tipo file</p>
        <button id="enviar" class="btn btn-primary"> Añadir </button>
    </form>
</div>
</div>

<?php include '../site_footer.php';   ?>