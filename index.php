<?php
	require_once("db_.php");
	if(!isset($_SESSION['idpersona']) or strlen($_SESSION['idpersona'])==0 or $_SESSION['autoriza']==0){
		header("location: ../correspondencia/login/");
	}
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<title>Salud Pública</title>
	<link rel="icon" type="image/png" href="img/favicon.ico">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Last-Modified" content="0">
	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
	<meta http-equiv="Pragma" content="no-cache">

	<link rel="stylesheet" href="lib/load/css-loader.css">


	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="lib/swal/dist/sweetalert2.min.css">
</head>

<body >
<header class="d-block p-2" id='header'>
	<nav class='navbar navbar-expand-sm navbar-dark fixed-top principal_menu'>

	  <img src='img/escudo.png' width='40' height='30' alt=''>
	  <img src='img/SSH.png' width='40' height='30' alt=''>
	  <a class='navbar-brand' href='#escritorio/dashboard' style='font-size:10px'>Sistema Administrativo de Salud Pública</a>

	  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#principal' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
	    <i class='fab fa-rocketchat'></i>
	  </button>

	  <div class='collapse navbar-collapse' id='principal'>
	    <ul class='navbar-nav mr-auto'>
	      <li class='nav-item dropdown'>
	        <a class='nav-link navbar-brand' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'></a>
	      </li>
	    </ul>
	   	<ul class='nav navbar-nav navbar-right' id='notificaciones'></ul>


	    <ul class='nav navbar-nav navbar-right' id='fondo'></ul>
	    <ul class='nav navbar-nav navbar-right'>
	      <li class='nav-item dropdown'>
	        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
	          <?php
	            if (file_exists('a_archivos/personal/'.trim($_SESSION['foto']))){
	            	echo "<img src='a_archivos/personal/".trim($_SESSION['foto'])."' class='rounded-circle' width='20px' height='20px'>";
	            }
	            else{
	              echo "<img src='a_personal/Screenshot_1.png' alt='Cuenta' class='rounded-circle' width='20px' height='20px'>";
	            }
	            echo $_SESSION['nick'];
	          ?>
	        </a>
	      </li>
	    </ul>
	    <ul class='nav navbar-nav navbar-right'>
	      <li class='nav-item'>
	        <a class='nav-link pull-left' onclick='salir()'>
	          <i class='fas fa-door-open' style='color:red;'></i>Salir
	        </a>
	      </li>
	    </ul>
	  </div>
	</nav>

</header>

<div class="page-wrapper d-block p-2" id='bodyx'>
	<div class='wrapper'>
    <div class='content navbar-default'>
      <div class='container-fluid' id='side_nav'>
				<div class='sidebar' id='navx'>

          <a href='#dash/dashboard' class='activeside'><i class='fas fa-home'></i><span>Inicio</span></a>
          <a href='#a_personal/index' title='Plantilla de personal'><i class='fas fa-users '></i> <span>Personal</span></a>
          <a href='#a_corresp/index' title='Correspondencia de entrada' ><i class='fas fa-arrow-circle-down'></i> <span>Entrada</span></a>
          <a href='#a_corresps/index' title='Correspondencia de salida'> <i class='fas fa-arrow-circle-up'></i> <span>Salida</span></a>

        </div>
			</div>

			<div class='fijaproceso main' id='contenido'>
			</div>
		</div>
	</div>
</div>

<div class="modal animated fadeInDown" tabindex="-1" role="dialog" id="myModal">
	<div class="modal-dialog" role="document" id='modal_dispo'>
		<div class="modal-content" id='modal_form'>

		</div>
	</div>
</div>

<div class="loader loader-default is-active" id='cargando' data-text="Cargando">
	<h2><span style='font-color:white'></span></h2>
</div>

</body>
	<!--   Core JS Files   -->
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

	<!--   url   -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />

	<!--   Alertas   -->
 	<script src="lib/swal/dist/sweetalert2.min.js"></script>

	<!--   para imprimir   -->
	<script src="lib/VentanaCentrada.js" type="text/javascript"></script>
	<!--   iconos   -->
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

	<!--   carrusel de imagenes   -->
	<link rel="stylesheet" href="lib/baguetteBox.js-dev/baguetteBox.css">
	<script src="lib/baguetteBox.js-dev/baguetteBox.js" async></script>
	<script src="lib/baguetteBox.js-dev/highlight.min.js" async></script>

	<!--   Cuadros de confirmación y dialogo   -->
	<link rel="stylesheet" href="lib/jqueryconfirm/css/jquery-confirm.css">
	<script src="lib/jqueryconfirm/js/jquery-confirm.js"></script>

	<script src="lib/popper.js"></script>
	<script src="lib/tooltip.js"></script>

	<!--   Propios   -->
	<link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2&display=swap" rel="stylesheet">
	<script src="saludpublica.js"></script>
	<link rel="stylesheet" type="text/css" href="lib/modulos.css"/>

	<!--   Boostrap   -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


</html>
