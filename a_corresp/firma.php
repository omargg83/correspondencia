<?php
	require_once("db_.php");
	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";

	if($db->nivel_personal==7){
		$sql="select personal.idpersona,personal.nombre from yoficiosp
		left outer join yoficiosp ofalias on ofalias.idoficiop=yoficiosp.idofp
		left outer join personal on personal.idpersona=yoficiosp.idpersturna
		where (ofalias.idpersturna='".$_SESSION['idpersona']."' or ofalias.idpersturna='".$_SESSION['superior']."') and yoficiosp.estado=0
		group by yoficiosp.idpersturna";
	}
	else{
		$sql="select personal.idpersona,personal.nombre from yoficiosp
		left outer join yoficiosp ofalias on ofalias.idoficiop=yoficiosp.idofp
		left outer join personal on personal.idpersona=yoficiosp.idpersturna
		where ofalias.idpersturna='".$_SESSION['idpersona']."' and yoficiosp.estado=0
		group by yoficiosp.idpersturna";
	}

	$per=$db->general($sql);
	echo "<h5><b>Entrega de documentos:</b></h5>";
		echo "<form id='consulta_avanzada' action='' data-destino='a_corresp/lista' data-div='resultado' data-funcion='entrada' autocomplete='off'>";
			echo "<div class='row'>";
				echo  "<div class='col-sm-4'>";
					echo "<label for='nombre'>Persona</label>";
					echo "<select name='idpersona_firma' id='idpersona_firma' class='form-control' onchange='persona_firma()'>";
					echo "<option value='' disabled selected>Seleccione una persona</option>";
						for($i=0;$i<count($per);$i++){
							echo  "<option value=".$per[$i]['idpersona'];
							echo  ">".$per[$i]['nombre']."</option>";
						}
					echo  "</select>";
				echo "</div>";
?>
				<div class='col-sm-4'>
					<div class='btn-group'>
					<button class='btn btn-outline-secondary btn-sm' type='button' id='acceso' onclick='persona_firma()'><i class='fas fa-search'></i>Seleccionar</button>
					</div>
				</div>
			</div>
		</form>
		<hr>
	</div>
	<div id='resultado' style="background-color:white;" class="container-fluid">
	</div>
