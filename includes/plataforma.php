<!--ALL with the latest version possible-->
<!--
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>-->
<div class=".d-none .d-lg-block .d-xl-none ml-5 especial"></div>
<div id="plataformas" class="col-lg-8 col-md-9 col-sm-8  texto_principal">
  <div class="row">
    <div class="col-lg-4 col-sm-6">
      <a href="http://www.juntadeandalucia.es/educacion/portals/web/ced/pasen" target="_blank"><img id="foto" src="../imagenes/svgpasen.svg"></a>
    </div>
    <div class="col-lg-4 col-sm-6">
      <a href="index.php?page=login" target="_blank"><img id="foto" src="../imagenes/logo.png"></a>
    </div>
    <?php $arrayPlataforma = Doctrine_Query::create()->from('Plataformas')
      ->execute();
    $longArray = count($arrayPlataforma);
    if ($longArray != 0 || !empty($arrayPlataforma)) {

      foreach ($arrayPlataforma as $plataforma) {
        //echo "$administrador->nombre $administrador->id";
        echo "
            <div class='col-lg-4 col-sm-6'>
            <a href='$plataforma->descripcion'
             target='_blank'>
             
             <img id='foto' src='../imagenes/$plataforma->foto'></a>
             </div>      
                  ";
      }
    } else {
      echo " No hay Plataformas ";
    }
