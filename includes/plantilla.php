<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Plataformas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--ALL with the latest version possible-->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<link rel="stylesheet" type="text/css" href="../assets/css/temaprincipal.css">
<script>
  var a = true;

  $(document).ready(function() {
    $(".menu-icon").click(() => {

      switch (a) {
        case true:
          a = false;
          $(".test").addClass("testFade");
          break;

        case false:
          a = true;
          setTimeout(function() {
            $(".testFade").removeClass("testFade");
          }, 400);
          break;
      }
    });
    $("#container").click(() => {
      $(".testFade").removeClass("testFade");
      if ($(".menu-toggle").prop("checked")) {
        //setInterval(function(){ alert("Hello"); }, 3000);
        $(".menu-icon").click();
      }
    });

  });
</script>

<body scroll="no">
  <!--Main Navigation https://codepen.io/illdapt/pen/amdQmg	https://codepen.io/web-tiki/pen/HhCyd  https://codepen.io/conorjmcnamara/pen/dLNdRo?&page=1    https://mdbootstrap.com/snippets/jquery/temp/590618?action=prism_export-->
  <!--HEADER-->
  <!--HEADER-->
  <div>
    <div class="test">
      <input type="checkbox" class="menu-toggle" id="menu-toggle">
      <div class="mobile-bar">
        <label for="menu-toggle" class="menu-icon">
          <span></span>
        </label>
      </div>

      <header class="header">
        <nav>
          <ul>
            <li><a href="index.php?page=home">Home</a></li>
            <li><a href="index.php?page=plataformas">Plataformas</a></li>

          </ul>
        </nav>
      </header>

      <a class="navbar-brand" href="index.html" style="padding:0px;">
        <img alt="logo" src="https://res.cloudinary.com/candidbusiness/image/upload/v1455406304/dispute-bills-chicago.png">
      </a>

    </div>
  </div>
  <div id="container" class="container-fluid">
    <div class="row">
      <nav id="sidebar" class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
        <ul class="nav nav-pills flex-column">
        <li class="nav-item">
						<a class="nav-link active" href="#">Overview <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="index.php?page=home">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Certificados</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="index.php?page=contacto">Contacta</a>
					</li>
				</ul>

				
      </nav>

    