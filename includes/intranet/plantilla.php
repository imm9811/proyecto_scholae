<?php error_reporting(0);?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Panel de control</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="../../imagenes/ico.ico" type="image/x-icon" />


  <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/dashboard/">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://v4-alpha.getbootstrap.com/dist/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../../assets/css/dashboard.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
    integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
    crossorigin="anonymous"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
    crossorigin="anonymous"></script>
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  <script language="javascript" type="text/javascript" src="../../plugins/BUSCADOR/jquery.dynacloud-5.js"></script>
  
  <script>

$(document).ready(function(){
    $("#buscador").click(function(){
    console.log($("#input-search").val());
     $("#input-search").val()==""? $(".highlight").css("background-color", "initial"):$('body').highlight($("#input-search").val()); 
      
    });      

$("#listarPlataforma").click(function(){
   $("#controladorListar").toggleClass("mostrar ocultar");
   $("#controladorAñadir").toggleClass("ocultar");
    });
});
          
  </script>
</head>
<!--https://v4-alpha.getbootstrap.com/examples/dashboard/-->

<body id="texto">
  <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
    <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse"
      data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Panel Control<sub>v1.0</sub></a>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Ajustes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Perfil</a>
        </li>
        
      </ul>
      <div class="form-inline mt-2 mt-md-0">
        <input id="input-search" class="form-control mr-sm-2" type="text" placeholder="Buscar">
        <button id="buscador" class="btn btn-outline-success my-2 my-sm-0">Buscar</button>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
        <ul class="nav nav-pills flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="#">Noticias <span class="sr-only">Noticias</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=plataforma">Noticias Lateral</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Categorias</a>
          </li>
        </ul>

        <ul class="nav nav-pills flex-column">
          <li class="nav-item">
            <a class="nav-link" href="#">Administradores</a>
        </li>
          
          <li class="nav-item">
            <a class="nav-link" target="_blank" href="https://analytics.google.com/analytics/web/provision/?authuser=3#/a139763291w200600872p194720812/admin">Google Analytics</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" target="_blank" href="https://tagmanager.google.com/#/container/accounts/4701925741/containers/11871666/workspaces/1">Google Task</a>
          </li>
        </ul>
      </nav>

      