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
