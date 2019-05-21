
<h2>Añadir de Categoría</h2>
<div class="table-responsive">
    <form role="form" action="../lib/api.php" class="formulario" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="apiMethod" value="setCategoría">
        <label class="formulario__label">Nombre de la caterogría</label>
        <input type="text" name="categoria" required class="formulario__input">

        <button id="enviar" class="btn btn-primary"> Añadir </button>
    </form>
</div>
<?php include '../site_footer.php';   ?>