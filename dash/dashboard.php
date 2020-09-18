<?php
	require_once("../control_db.php");
	$bdd = new Salud();
	$row = $bdd->permiso($_SESSION['idpersona']);
?>
	<div class='container-fluid'>
		<div class="card-group">
			<div class="card bg-light col-sm-12 col-md-12 col-lg-6 col-xl-2" >
				<div class="card-body text-center">
					<div class='row'>
						<div class='col-4'>
							<i class='fas fa-arrow-circle-down fa-2x'></i>
						</div>
						<div class='col-8'>
							<p class="card-text">Correspondencia <br>de Entrada</p>
						</div>
					</div>
					<hr>
					<div class='row'>
						<div class='col-12'>
							<a class="btn btn-light btn-sm btn-lg btn-block" href='#a_corresp/index'><i class="fas fa-sign-in-alt"></i>Ir</a>
						</div>
					</div>
				</div>
			</div>

			<div class="card bg-light col-sm-12 col-md-12 col-lg-6 col-xl-2" >
				<div class="card-body text-center">
					<div class='row'>
						<div class='col-4'>
							<i class='fas fa-arrow-circle-up fa-2x'></i>
						</div>
						<div class='col-8'>
							<p class="card-text">Correspondencia <br>de Salida</p>
						</div>
					</div>
					<hr>
					<div class='row'>
						<div class='col-12'>
							<a class="btn btn-light btn-sm btn-lg btn-block" href='#a_corresps/index'><i class="fas fa-sign-in-alt"></i>Ir</a>
						</div>
					</div>
				</div>
			</div>

			<div class="card bg-light col-sm-12 col-md-12 col-lg-6 col-xl-2" >
				<div class="card-body text-center">
					<div class='row'>
						<div class='col-4'>
							<i class='fas fa-users fa-2x '></i>
						</div>
						<div class='col-8'>
							<p class="card-text">Plantilla de personal</p>
						</div>
					</div>
					<hr>
					<div class='row'>
						<div class='col-12'>
							<a class="btn btn-light btn-sm btn-lg btn-block" href='#a_personal/index'><i class="fas fa-sign-in-alt"></i>Ir</a>
						</div>
					</div>
				</div>
			</div>

			<div class="card bg-light col-sm-12 col-md-12 col-lg-6 col-xl-2" >
				<div class="card-body text-center">
					<div class='row'>
						<div class='col-4'>
							<i class='fas fa-clipboard fa-2x '></i>
						</div>
						<div class='col-8'>
							<p class="card-text">Oficios de<br> Comisión</p>
						</div>
					</div>
					<hr>
					<div class='row'>
						<div class='col-12'>
							<a class="btn btn-light btn-sm btn-lg btn-block" href='#a_comision/index'><i class="fas fa-sign-in-alt"></i>Ir</a>
						</div>
					</div>
				</div>
			</div>
	</div>
	<hr>


	<div class='row'>
		<div class='col-12'>
			<div class='alert alert-primary'><i class='fas fa-file-pdf'></i>Fondos de pantalla para todos los equipos</div>
		</div>
	</div>

	<div class="card-group">
		<div class="card bg-light text-white col-sm-12 col-md-6 col-lg-4 col-xl-2">
		  <img class="card-img" src="a_publicacion/1730x1080CORONAVIRUS-01.jpg" alt="Card image" width='100%' height='180px'>
		  <div class="card-img-overlay"><br>
				<h5 class="card-title text-center" style='color:black:font-weight: bold;'>FONDO DE ESCRITORIO 1</h5>
				<a class="btn btn-light btn-sm btn-lg btn-block" href='a_publicacion/1730x1080CORONAVIRUS-01.jpg' download="imagen1">Descargar</a>
		  </div>
		</div>

		<div class="card bg-light text-white col-sm-12 col-md-6 col-lg-4 col-xl-2">
		  <img class="card-img" src="a_publicacion/1730x1080CORONAVIRUS-02.jpg" alt="Card image" width='100%' height='180px'>
		  <div class="card-img-overlay"><br>
				<h5 class="card-title text-center" style='color:black:font-weight: bold;'>FONDO DE ESCRITORIO 2</h5>
				<a class="btn btn-light btn-sm btn-lg btn-block" href='a_publicacion/1730x1080CORONAVIRUS-02.jpg' download="imagen2">Descargar</a>
		  </div>
		</div>

		<div class="card bg-light text-white col-sm-12 col-md-6 col-lg-4 col-xl-2">
		  <img class="card-img" src="a_publicacion/1730x1080CORONAVIRUS-03.jpg" alt="Card image" width='100%' height='180px'>
		  <div class="card-img-overlay"><br>
				<h5 class="card-title text-center" style='color:black:font-weight: bold;'>FONDO DE ESCRITORIO 3</h5>
				<a class="btn btn-light btn-sm btn-lg btn-block" href='a_publicacion/1730x1080CORONAVIRUS-03.jpg' download="imagen3">Descargar</a>
		  </div>
		</div>

		<div class="card bg-light text-white col-sm-12 col-md-6 col-lg-4 col-xl-2">
		  <img class="card-img" src="a_publicacion/1730x1080CORONAVIRUS-04.jpg" alt="Card image" width='100%' height='180px'>
		  <div class="card-img-overlay"><br>
				<h5 class="card-title text-center" style='color:black:font-weight: bold;'>FONDO DE ESCRITORIO 4</h5>
				<a class="btn btn-light btn-sm btn-lg btn-block" href='a_publicacion/1730x1080CORONAVIRUS-04.jpg' download="imagen4">Descargar</a>
		  </div>
		</div>

		<div class="card bg-light text-white col-sm-12 col-md-6 col-lg-4 col-xl-2">
		  <img class="card-img" src="a_publicacion/fondo1.jpg" alt="Card image" width='100%' height='180px'>
		  <div class="card-img-overlay"><br>
				<h5 class="card-title text-center" style='color:black:font-weight: bold;'>FONDO DE ESCRITORIO 5</h5>
				<a class="btn btn-light btn-sm btn-lg btn-block" href='a_publicacion/fondo1.jpg' download="imagen5">Descargar</a>
		  </div>
		</div>

		<div class="card bg-light text-white col-sm-12 col-md-6 col-lg-4 col-xl-2">
		  <img class="card-img" src="a_publicacion/fondo2.jpg" alt="Card image" width='100%' height='180px'>
		  <div class="card-img-overlay"><br>
				<h5 class="card-title text-center" style='color:black:font-weight: bold;'>FONDO DE ESCRITORIO 6</h5>
				<a class="btn btn-light btn-sm btn-lg btn-block" href='a_publicacion/fondo2.jpg' download="imagen6">Descargar</a>
		  </div>
		</div>

		<div class="card bg-light text-white col-sm-12 col-md-6 col-lg-4 col-xl-2">
		  <img class="card-img" src="a_publicacion/fondo3.png" alt="Card image" width='100%' height='180px'>
		  <div class="card-img-overlay"><br>
				<h5 class="card-title text-center" style='color:black:font-weight: bold;'>FONDO DE ESCRITORIO 7</h5>
				<a class="btn btn-light btn-sm btn-lg btn-block" href='a_publicacion/fondo3.png' download="imagen7">Descargar</a>
		  </div>
		</div>


	</div>


</div>


<?php
	echo "<div class='container-fluid'><br>";
		echo "<div class='alert alert-primary'><a href='manuales/Manual_tenico.pdf' target='blank_'><i class='fas fa-file-pdf'></i>Manual técnico módulo comités</a></div>";
		echo "<div class='alert alert-primary'><a href='manuales/Manual_operativo.pdf' target='blank_'><i class='fas fa-file-pdf'></i>Manual Operativo módulo comités</a></div>";

		echo "<div class='alert alert-light' style='opacity:.9'>
		<h5><center>
			Lema:
			</center>
		</h5>";
		echo $_SESSION['lema'];
		echo "</div>";

		echo "<div class='alert alert-light' style='opacity:.9'>";
		echo "<b>Nota:</b> Si el sistema presenta algún error favor de presionar juntas las teclas Control+ F5 (Ctrl+F5), ya que constantemente se están subiendo actualizaciones y esto permite tener la última versión actualizada..";
		echo "</div>";

		echo "<div class='alert alert-primary' style='opacity:.9'>";
		echo "<b>Actualizaciones:</b> ";
		echo "<br>- <b>Calendario de salidas</b> (04122019): Crear oficios de comisión para las salidas. <span class='badge badge-secondary'>New</span></h1>";
		echo "<br>- <b>Oficios de comisión</b> (04122019): Rubricas. <span class='badge badge-secondary'>New</span></h1>";
		echo "<br>- <b>Correspondencia</b> (10092019): Mantenimiento y actualización de busquedas.</h1>";
		echo "<br>- <b>Comités</b> (10092019): Mejora de asistentes. </h1>";
		echo "<br>- <b>Inventario</b> (10092019): nuevas opciones. </h1>";
		echo "<br>- <b>Sistema</b> (10092019): Se optimiza el sistema. </h1>";
		echo "<br>- <b>Presupuesto</b> (01082019): Se agrega el modulo de presupuestos.</h1>";
		echo "<br>- <b>Comités</b> (31072019): Se actúaliza lista de acuerdos y metas. </h1>";
		echo "<br>- <b>Comités</b> (31072019): Se agrega responsable a los acuerdos y metas. </h1>";
		echo "<br>- <b>Correspondencia</b> (31072019): Se habilitó contestar el oficio de entrada con los acuses de los oficios de salida, si en caso de no encontrarse se puede solicitar acceso al oficio de salida o subirlo directamente.</h1>";
		echo "<br>- <b>Correspondencia</b> (18072019): Ya esta habilitado en el módulo de correspondencia de salida subir acuses escaneados. </h1>";
		echo "<br>- <b>Correspondencia</b> (18072019): Ya se pueden buscar oficios de entrada y salida en todo el sistema, si el oficio no le ha sido turnado, se puede solicitar el turno. </h1>";
		echo "</div>";
	echo "</div>";

?>
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4' style='opacity:.9'>
				<div class="alert alert-light" style='width:100%;height:300px; overflow:auto;'>
					<b><center>Cuentas de personal
					<?php
						//if(array_key_exists('PERSONAL', $bdd->derecho) and $bdd->derecho['PERSONAL']['acceso']==1)
						echo "<a class='btn btn-outline-info btn-sm float-right' href='#a_personal/personal' title='ir'><i class='fas fa-glasses'></i></a></center></b>";
					?>
					<canvas id="personal" height='200' width='200'>

					</canvas>
				</div>
			</div>

			<div class='col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4' style='opacity:.9'>
				<div class="alert alert-light" style='width:100%;height:300px; overflow:auto;'>
					<b><center>C. de Entrada
					<?php
						//if(array_key_exists('CORRESPONDENCIA', $bdd->derecho) and $bdd->derecho['CORRESPONDENCIA']['acceso']==1)
						echo "<a class='btn btn-outline-info btn-sm float-right' href='#a_corresp/entrada' title='ir'><i class='fas fa-glasses'></i></a>";
						echo "</center></b>";
					?>
					<canvas id="speedChart" height='400' width='200'>

					</canvas>
				</div>
			</div>
			<div class='col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4' style='opacity:.9'>
				<div class="alert alert-light" style='width:100%;height:300px; overflow:auto;'>
					<b><center>Comités
					<?php
						if(array_key_exists('COMITES', $bdd->derecho) and $bdd->derecho['COMITES']['acceso']==1)
						echo "<a class='btn btn-outline-info btn-sm float-right' href='#a_comite/inicio' title='ir'><i class='fas fa-glasses'></i></a>";
						echo "</center></b>";
					?>
					<canvas id="comite" height='200' width='200'>

					</canvas>
				</div>
			</div>

			<div class='col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4' style='opacity:.9'>
				<div class="alert alert-light" style='width:100%;height:300px; overflow:auto;'>
					<b><center>Comisión
					<?php
						echo "<a class='btn btn-outline-info btn-sm float-right' href='='#a_comision/comision' title='ir'><i class='fas fa-glasses'></i></a>";
						echo "</center></b>";
					?>
					<canvas id="comision" height='200' width='200'>

					</canvas>
				</div>
			</div>

		</div>
	</div>
<?php
	echo "<div class='container-fluid'><br>";
		echo "<div class='row'>";
			echo "<div class='col-sm-4' style='opacity:.9'>";
				echo "<div class='alert alert-light'>";
				echo "<i class='fas  fa-arrow-circle-right'></i> <b>Misión</b>";
				echo "<p>Garantizar la protección de la salud definiendo, implementando y evaluando políticas, programas y servicios encaminados a la investigación, promoción, prevención, restauración y conservaci&oacute;n de la salud, a través de una atención integral, basada en criterios de universalidad, equidad, excelencia y calidad, que fomente el desarrollo humano y contribuya a elevar el nivel de vida de los hidalguenses.</p>";
				echo "</div>";
			echo "</div>";

			echo "<div class='col-sm-4' style='opacity:.9'>";
				echo "<div class='alert alert-light'>";
				echo "<i class='fas fa-arrow-circle-down'></i> <b>Visión</b>";
				echo "<p>Ser la institución líder y rectora del Sistema Estatal de Salud, que a través de políticas y estrategias norme y garantice el acceso a servicios con calidad para la atenci&oacute;n y preservaci&oacute;n de la salud en forma confiable, resolutiva e innovadora, contribuyendo as&iacute; al bienestar social de los hidalguenses. </p>";
				echo "</div>";
			echo "</div>";

			echo "<div class='col-sm-4' style='opacity:.9'>";
				echo "<div class='alert alert-light'>";
				echo "<i class='fas  fa-arrow-circle-right'></i> <b>Valores</b>";
				echo "<p>- Honestidad";
				echo "<br>- Lealtad";
				echo "<br>- Responsabilidad";
				echo "<br>- Compromiso";
				echo "<br>- Ética Profesional";
				echo "<br>- Humildad";
				echo "<br>- Respeto";
				echo "<br>- Calidad";
				echo "<br>- Espíritu de Servicio</p>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</div>";

?>
	<script type="text/javascript">

		$(document).ready(function(){
			setTimeout(person_grap, 2000);
			setTimeout(corres_grap, 4000);
			setTimeout(comite_grap, 6000);
			setTimeout(comisi_grap, 8000);
		});

		function corres_grap(){
			var parametros={
				"function":"correspondencia"
			};
			$.ajax({
				url: "escritorio/datos_orga.php",
				method: "GET",
				data: parametros,
				success: function(data) {
					var player = [];
					var score = [];
					var datos = JSON.parse(data);
					for (var x = 0; x < datos.length; x++) {
						player.push(datos[x].nombre + " "+ datos[x].total );
						score.push(datos[x].total);
					}
				  var chartdata = {
					labels: player,
					datasets : [
					  {
						label: 'Oficios pendientes por contestar',
						backgroundColor: 'rgba(255, 99, 132, 0.6)',
						borderColor: 'rgba(200, 200, 200, 0.75)',
						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						data: score
					  }
					]
				  };
				var ctx = $("#speedChart");
					  var barGraph = new Chart(ctx, {
						type: 'horizontalBar',
						data: chartdata,
						options: {
							legend: {
								"display": true
							},
							tooltips: {
								"enabled": false
							}
						}
					  });
				},
				error: function(data) {

				}
			  });
		};
		function comisi_grap(){
			var parametros={
				"function":"comision"
			};
			$.ajax({
				url: "escritorio/datos_orga.php",
				method: "GET",
				data: parametros,
				success: function(data) {
					var player = [];
					var score = [];
					var datos = JSON.parse(data);
					for (var x = 0; x < datos.length; x++) {
						player.push(datos[x].nombre + " "+ datos[x].total );
						score.push(datos[x].total);
					}

				  var chartdata = {
					labels: player,
					datasets : [
					  {
						label: 'Oficios de comision elaborados en el año',
						backgroundColor: 'rgba(255, 99, 132, 0.6)',
						borderColor: 'rgba(200, 200, 200, 0.75)',
						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						data: score
					  }
					]
				  };
				var ctx = $("#comision");
					  var barGraph = new Chart(ctx, {
						type: 'horizontalBar',
						data: chartdata,
						options: {
							legend: {
								"display": true
							},
							tooltips: {
								"enabled": false
							}
						}
					  });
				},
				error: function(data) {

				}
			  });
		};
		function comite_grap(){
			var parametros={
				"function":"comite"
			};
			$.ajax({
				url: "escritorio/datos_orga.php",
				method: "GET",
				data: parametros,
				success: function(data) {
					var player = [];
					var score = [];
					var datos = JSON.parse(data);
					for (var x = 0; x < datos.length; x++) {
						player.push(datos[x].nombre + " "+ datos[x].total );
						score.push(datos[x].total);
					}
				  var chartdata = {
					labels: player,
					datasets : [
					  {
						label: 'Numero de fechas por comite',
						backgroundColor: 'rgba(255, 99, 132, 0.6)',
						borderColor: 'rgba(200, 200, 200, 0.75)',
						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						data: score
					  }
					]
				  };
				var ctx = $("#comite");
					  var barGraph = new Chart(ctx, {
						type: 'horizontalBar',
						data: chartdata,
						options: {
							legend: {
								"display": true
							},
							tooltips: {
								"enabled": false
							}
						}
					  });
				},
				error: function(data) {

				}
			  });
		};
		function person_grap(){
			var parametros={
				"function":"personal"
			};
			$.ajax({
				url: "escritorio/datos_orga.php",
				method: "GET",
				data: parametros,
				success: function(data) {
					var player = [];
					var score = [];
					var validado = [];
					var datos = JSON.parse(data);
					for (var x = 0; x < datos.length; x++) {
						player.push(datos[x].nombre + " "+ datos[x].total );
						score.push(datos[x].total);
						validado.push(datos[x].validado);
					}
				  var chartdata = {
					labels: player,
					datasets : [
					  {
						label: 'Número de personal',
						backgroundColor: 'rgba(255, 99, 132, 0.6)',
						borderColor: 'rgba(200, 200, 200, 0.75)',
						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						data: score
					  },
					  {
						label: 'Personal validado',
						backgroundColor: 'rgba(139, 185, 221, 1.0)',
						borderColor: 'rgba(200, 200, 200, 0.75)',
						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						data: validado
					  }
					]
				  };
				var ctx = $("#personal");
					  var barGraph = new Chart(ctx, {
						type: 'horizontalBar',
						data: chartdata,
						options: {
							legend: {
								"display": true
							},
							tooltips: {
								"enabled": true
							}
						}
					  });
				},
				error: function(data) {

				}
			  });
		};
    </script>
