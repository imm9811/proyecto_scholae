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
  $plataforma = Doctrine_Query::create()->from('Administradores')
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
        <label class="formulario__label">Nombre</label>
        <input type="text" name="titulo" value="<?php echo $plataforma->nombre ?>" class="formulario__input">

        <label class="formulario__label">Foto</label>
        <input type="text"  name="file" value="<?php echo $plataforma->apellidos ?>" class="formulario__input">

        <label class="formulario__label">Enlace</label>
        <input type="text" name="username" value="<?php echo $plataforma->username ?>" class="formulario__input">

        <button id="enviar" class="btn btn-primary"> Añadir </button>
    </form>
</div>
</div>

<?php include '../site_footer.php';   ?>