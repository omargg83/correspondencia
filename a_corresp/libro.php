<?php
	require_once("db_.php");
	$fecha=date("d-m-Y");
	$nuevafecha = strtotime ( '-5 day' , strtotime ( $fecha ) ) ;
	$fecha1 = date ( "d-m-Y" , $nuevafecha );

	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br><h5><b>Entrega de documentos:</b></h5>";
		echo "<form id='consulta_avanzada' action='' data-destino='a_corresp/lista' data-div='resultado' data-funcion='libro' autocomplete='off'>";
			echo "<div class='row'>";
?>
				<div class='col-sm-2'>
					<label>Desde:</label>
					<input class="form-control fechaclass" placeholder="Desde...." type="text" id='desde' name='desde' value='<?php echo $fecha1; ?>'>
				</div>

				<div class='col-sm-2'>
					<label>Hasta:</label>
					<input class="form-control fechaclass" placeholder="Hasta...." type="text" id='hasta' name='hasta' value='<?php echo $fecha; ?>'>
				</div>

				<div class='col-sm-4'>
					<div class='btn-group'>
					<button class='btn btn-outline-secondary btn-sm' type='submit' id='acceso'><i class='fas fa-search'></i>Buscar</button>
					</div>
				</div>
			</div>
		</form>
		<hr>
	</div>

	<div id='resultado' style="background-color:white;" class="container-fluid">

	</div>

<script>
	$(document).ready( function () {
		fechas();
		$("#resultado").load('a_corresp/lista.php?funcion=libro');
	});
</script>
