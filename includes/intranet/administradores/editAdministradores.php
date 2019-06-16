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

  $idAdmim=$_GET['id'];
  $admin = Doctrine_Query::create()->from('Administrador')
  ->where("id = ?", $idAdmim)
  ->execute()
  ->getFirst();


?>
<div class="editarFormulario ocultar">
<h2>Editar Administrador</h2>
<div class="table-responsive">
    <form role="form" action="../lib/api.php" class="formulario" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="apiMethod" value="setAdministradores">
        <input type="hidden" name="id" value="<?php echo $admin->id ?>">
        <label class="formulario__label">Nombre</label>
        <input type="text" name="usuario" value="<?php echo $admin->nombre ?>" class="formulario__input">

        <label class="formulario__label">Apellidos</label>
        <input type="text"  name="apellido" value="<?php echo $admin->apellidos ?>" class="formulario__input">

        <label class="formulario__label">Alias</label>
        <input type="text" name="alias" value="<?php echo $admin->alias ?>" class="formulario__input">

        <label class="formulario__label">Correo</label>
        <input type="email" name="correo" value="<?php echo $admin->correo ?>" class="formulario__input">

        <label class="formulario__label">Contraseña</label>
        <input type="password" name="contrasena" placeholder="rellenar para cambiar" class="formulario__input">

        <button id="enviar" class="btn btn-primary"> Editar </button>
    </form>
</div>
</div>

<?php include '../site_footer.php';   ?>