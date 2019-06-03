
<h2>Añadir de Categoría</h2>
<div class="table-responsive">
    <form role="form" action="../lib/api.php" class="formulario" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="apiMethod" value="setCategoria">
        <label class="formulario_label">Nombre de la categoría</label>
        <input type="text" name="nombre" required class="formulario__input">

        <button id="enviar" class="btn btn-primary"> Añadir </button>
    </form>
</div>
<?php include '../site_footer.php';   ?>