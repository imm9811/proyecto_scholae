
<h2>Añadir Noticia Lateral</h2>
<div class="table-responsive">
    <form role="form" action="../lib/api.php" class="formulario" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="apiMethod" value="setPp_aside">

        <label>Titulo</label>
        <input type="text" name="titulo" required  class="formulario_input">
        
        <label>Descripcion</label>
        <textarea name="descripcion"></textarea>
                <script>
                        CKEDITOR.replace( 'descripcion' );
                </script>
        <br/>
        <label>Foto</label>
        <input type="file" name="foto"  class="formulario_input">
        <br>
        <br>
        <br>
        
        <label>Archivos</label>
        <input type="file" name="archivos[]" multiple  class="formulario_input">

        <button id="enviar" class="btn btn-primary"> Añadir </button>
    </form>
</div>
<?php include '../site_footer.php';   ?>