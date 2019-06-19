
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
  $noticia = Doctrine_Query::create()->from('Noticia')
  ->where("id = ?", $idNoticia)
  ->execute()
  ->getFirst();
  $video;
  $arrayMultimedia = Doctrine_Query::create()->from('Multimedia')
  ->where("noticia_id = ?", $idNoticia)
  ->execute();

    
  foreach ($arrayMultimedia as $archivo) 
  {   
     if(strpos($archivo->url, ".")==false){
      $video=$archivo->url;
      $id_video=$archivo->id;
     } 
  } 
?>

<div class="editarFormulario ocultar">

<h2>Editar Noticia</h2>

<div class="table-responsive">
    <form role="form" action="../lib/api.php" class="formulario" method="post" enctype="multipart/form-data">
        
        <input type="hidden" name="apiMethod" value="setNoticias">
        <input type="hidden" name="id" value="<?php echo $noticia->id ?>">
        <input type="hidden" name="id_video" value="<?php echo $id_video  ?>">
        <input type="hidden" name="arrayFotos" id="arrayFotos"/>

        <label class="formulario__label">Título <?php echo "viwdeo".$video ?></label>
        <input type="text" name="titulo" value="<?php echo $noticia->titulo ?>" required  class="formulario__input">

        <label class="formulario__label">Descripcion</label>
        <textarea name="descripcion1"><?php echo $noticia->descripcion ?></textarea>
        <script>
            CKEDITOR.replace('descripcion1');
        </script>
        <br/>
        <label class="formulario__label">Imágenes y Archivos (Múltiples)</label>
        <input type="file" name="archivo[]" multiple class="formulario_input">
        <br>
        <label>Lista de Imágenes y Archivos</label>
        <?php 

    foreach ($arrayMultimedia as $archivo) 
    {
        if($archivo->eliminado==0){    
            $aArchivo = explode(".", $archivo->url);

            $ubicacion = "../../assets/images/$archivo->url";
            if(isset($aArchivo[count($aArchivo)-1]) && count($aArchivo) > 1)
            {
                $codigoExtension = 0;
                $check = false;
                for($i = 0;$i < count($arrayFormatosImagenes) && 
                $check == false;$i++)
                {
                    if($arrayFormatosImagenes[$i] == $aArchivo[count($aArchivo)-1])
                    {
                        echo " 
                        <div id='$archivo->id'>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <img width='150px'  src='$ubicacion'>  
                                </div>
                                <div class='col-lg-6 boton_falso'>
                                    <div onclick='funciona($archivo->id)'>X</div>
                                </div>
                            </div>
                        </div>
                        ";
                    }
                }
                for($j = 0;$j < count($arrayFormatosTextos) && 
                $check == false;$j++)
                {
                    if($arrayFormatosTextos[$j] == $aArchivo[count($aArchivo)-1])
                    {
                        echo " 
                        <div id='$archivo->id'> 
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <p src='$ubicacion'> $archivo->url </p>  
                                </div>
                                <div class='col-lg-6 boton_falso'>
                                    <div onclick='funciona($archivo->id)'>X</div>
                                </div>
                            </div>
                        </div>
                        ";
                    }
                }

            }
        }
    }
            
        
        ?>
        <label class="formulario__label">Video (Solo uno)  </label>
        <input type="text" value='<?php echo $video ?>' name="video" multiple class="formulario_input">
        <br>
        <label class="formulario__label">Categorias donde se mostrará</label>
        <select style="width:40%; margin-left:25%;" class="form-control formulario_input" name="categorias">
            
            <?php $arrayCategrias = Doctrine_Query::create()->from('Categoria')
                ->execute();
            $longArray = count($arrayCategrias);
            if ($longArray != 0) {

                foreach ($arrayCategrias as $categoria) {
                    if($categoria->id==$noticia->categoria_id){
                        echo "
                        <option selected value=$categoria->id>$categoria->nombre</option>
                    "; 
                    }else{
                        echo "<option value=$categoria->id>$categoria->nombre</option>";
                    }
                   
                }
            }
            else{
            echo "<option>No hay valores</option>";
            }?>
        </select>
        <p>*Por cuestiones de privacidad HTML no permite asignar valores a los campos tipo file, así que hay que seleccionar un archivo obligatoriamente</p>
        <button id="enviar" class="btn btn-primary"> Editar </button>
        
        <script>
var arrayFotos=[];
function funciona(id){
    var statusConfirm = confirm("¿Desea borrar la foto? Recuerde que después tiene que pulsar Editar para que se efectuen los cambios");
    if (statusConfirm == true)
    {
        arrayFotos.push(id);
        $("#arrayFotos").val(arrayFotos);
        $('#'+id).hide();
    } if (statusConfirm == false)
    {
        return false;
    }
   
}
</script>
    </form>
  
</div>
</div>

<?php include '../site_footer.php';   ?>