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
      <a href="index.php?page=login" target="_blank"><img id="foto" src="../imagenes/logo.png"></a>
    </div>
    
    <?php $arrayPlataforma = Doctrine_Query::create()->from('Plataforma')
      ->execute();
    $longArray = count($arrayPlataforma);
    if ($longArray != 0 ) {

      foreach ($arrayPlataforma as $plataforma) {
        //echo "$administrador->nombre $administrador->id";
        echo "
            <div class='col-lg-4 col-sm-6'>
            <a href='$plataforma->enlace'
             target='_blank'>
             
             <img id='foto' alt='$plataforma->titulo' src='../imagenes/$plataforma->foto'></a>
             </div>      
                  ";
      }
    } 
