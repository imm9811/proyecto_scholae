<h2>Añadir Noticia</h2>
<div class="table-responsive">
    <form role="form" action="../lib/api.php" class="formulario" method="post" enctype="multipart/form-data">

        <input type="hidden" name="apiMethod" value="setNoticias">

        <label class="formulario__label">Titulo</label>
        <textarea name="titulo" required class="formulario_input" rows="1" cols="40"></textarea>

        <label class="formulario__label">Descripcion</label>
        <textarea name="descripcion"></textarea>
        <script>
            CKEDITOR.replace('descripcion');
        </script>
        <br/>
        <label class="formulario__label">Imágenes y Archivos (Múltiples)</label>
        <input type="file" name="archivo[]" multiple class="formulario_input">
        <br>
        <br>
        <br>
        <label class="formulario__label">Categorias donde se mostrará</label>
        <select style="width:40%; margin-left:25%;" class="form-control formulario_input" name="categorias">
            
            <?php $arrayCategrias = Doctrine_Query::create()->from('Categoria')
                ->execute();
            $longArray = count($arrayCategrias);
            if ($longArray != 0) {

                foreach ($arrayCategrias as $categoria) {

                    echo "
                        <option value=$categoria->id>$categoria->nombre</option>
                    ";
                }
            }
            else{
            echo "<option>No hay valores</option>";
            }?>
        </select>

        <button id="enviar" class="btn btn-primary"> Añadir </button>
    </form>
</div>
<?php include '../site_footer.php';   ?>