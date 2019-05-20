
<h2>Añadir Plataforma</h2>
<div class="table-responsive">
    <form role="form" action="../lib/api.php" class="formulario" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="apiMethod" value="setPlataformas">
        <label class="formulario__label">Nombre</label>
        <input type="text" name="titulo" required  class="formulario__input">

        <label class="formulario__label">Foto</label>
        <input type="file" name="file" required  class="formulario__input">
        <label class="formulario__label">Enlace</label>
        <input type="text" name="enlace" required class="formulario__input">

        <button id="enviar" class="btn btn-primary"> Añadir </button>
    </form>
</div>
<?php include '../site_footer.php';   ?>