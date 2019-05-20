
<?php
if(isset($_POST['id'])){
  $idAdmim=$_POST['id'];
  $admin = Doctrine_Query::create()->from('Administradores')
  ->execute()
  ->getFirst();
}
?>
<h2>Añadir de Administradores</h2>
<div class="table-responsive">
    <form role="form" action="../lib/api.php" class="formulario" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="apiMethod" value="setAdministradores">
        <label class="formulario__label">Nombre</label>
        <input type="text" name="usuario" required value="<?php isset($admin->nombre) ?>" class="formulario__input">

        <label class="formulario__label">Apellidos</label>
        <input type="text"  name="apellido" required value="<?php isset($admin->apellidos) ?>" class="formulario__input">

        <label class="formulario__label">Username</label>
        <input type="text" name="username" required value="<?php isset($admin->username) ?>" class="formulario__input">

        <label class="formulario__label">Correo</label>
        <input type="email" name="correo" required value="<?php isset($admin->correo) ?>" class="formulario__input">

        <label class="formulario__label">Contraseña</label>
        <input type="password" required name="contrasena" class="formulario__input">

        <button id="enviar" class="btn btn-primary"> Añadir </button>
    </form>
</div>
<?php include '../site_footer.php';   ?>