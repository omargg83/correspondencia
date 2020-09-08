<?php
	require_once("db_.php");
	$id=$_REQUEST['id'];

	$tipo=0;
	if (isset($_REQUEST['id2'])){
		$tipo=$_REQUEST['id2'];
	}

  $lectura="";
 	$result = $db->c_oficio_resp($id);
	$c_archivos = $db->c_archivos_resp($id);
	$c_acuse = $db->c_acuse_resp($id);

	$numero=$result['numero'];
	$fecha= fecha($result['fecha']);

	$documento=$result['documento'];
	$destinatario=$result['destinatario'];
	$cargo=$result['cargo'];
	$dependencia=$result['dependencia'];
	$asunto=$result['asunto'];
	$idfirma=$result['idfirma'];
	$idausencia=$result['idausencia'];
	$idelabora=$result['idelabora'];
	$observaciones=$result['observaciones'];
	$contestado=$result['contestado'];
	$entrega=$result['entrega'];
	$cancelado=$result['cancelado'];

  echo "<hr>";
	echo "<div class='card'>";
			echo "<form id='form_corress' action='' data-lugar='a_corresps/db_' data-destino='a_corresps/editar' data-funcion='guardar'>";
			echo "<input type='hidden' id='id_of' NAME='id_of' value='$id'>";
			echo "<div class='card-header'># $numero</div>";
				echo "<div class='card-body'>";
					echo "<div class='row'>";
						echo  "<div class='col-sm-3'>";
							echo "<label for='numero'>Numero:</label>";
							echo "<br>".$numero;
						echo "</div>";

						echo  "<div class='col-sm-3'>";
							echo "<label for='correo'>Fecha:</label>";
							echo "<br>".fecha($fecha);
						echo "</div>";

						echo  "<div class='col-sm-3'>";
							echo "<label for='correo'>Documento:</label>";
							echo "<br>".$documento;
						echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
						echo  "<div class='col-sm-12'>";
							echo "<label for='correo'>Destinatario:</label>";
							echo "<br>".$destinatario;
              echo "<br>".$cargo;
              echo "<br>".$dependencia;
						echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
						echo  "<div class='col-sm-12'>";
							echo "<label for='correo'>Asunto:</label>";
							echo "<br>".$asunto;
						echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
						echo  "<div class='col-sm-4'>";
							echo "<label for='correo'>Firma:</label>";
							$personal = $db->personal_edit($idfirma);
							echo "<br>".$personal['nombre'];
						echo "</div>";

						echo  "<div class='col-sm-4'>";
							echo "<label for='correo'>Firma:</label>";
							if(strlen($idausencia)){
								$personal = $db->personal_edit($idausencia);
								echo "<br>".$personal['nombre'];
							}

						echo "</div>";
						echo  "<div class='col-sm-4'>";
							echo "<label for='correo'>Generó:</label>";
							if(strlen($idelabora)){
								$personal = $db->personal_edit($idelabora);
								echo "<br>".$personal['nombre'];
							}
						echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
						echo  "<div class='col-sm-12'>";
							echo "<label for='otra'>Observaciones:</label>";
							echo "<br>".$observaciones;
						echo "</div>";
					echo "</div>";
				echo "</div>";

				echo "<div class='card-footer'>";
					echo "<div class='btn-group'>";
						echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='agregar_corresp'><i class='fas fa-clipboard-check'></i>Seleccionar</button>";
						echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal'><i class='fas fa-undo-alt'></i>Cerrar</button>";
					echo "</div>";
				echo "</div>";
				echo "</form>";

				echo "<div class='card-header'>Documento</div>";
				echo "<div class='card-body'>";
					echo "<div class='row'>";
						echo "<div class='baguetteBoxOne gallery'>";
							for($fil=0;$fil<count($c_archivos);$fil++){
								echo "<div style='border:.1px solid silver;float:left;margin:10px'>";
									echo "<a href='".$db->doc.$result['anio']."_s/".$c_archivos[$fil]['direccion']."' data-caption='Correspondencia' target='nuevo'>";
										echo "<img src='".$db->doc.$result['anio']."_s/".$c_archivos[$fil]['direccion']."' alt='Correspondencia' >";
									echo "</a><br>";
								echo "</div>";
							}
						echo "</div>";
					echo "</div>";
				echo "</div>";

				echo "<div class='card-header'>Acuse</div>";
				echo "<div class='card-body' style='float:left;width:100%;max-height:400px;overflow: auto;border: 0px;'  id='acuse'>";

				echo "<div class='row'>";
					echo "<div class='baguetteBoxOne gallery'>";
						for($fil=0;$fil<count($c_acuse);$fil++){
							echo "<div style='border:.1px solid silver;float:left;margin:10px'>";
								echo "<a href='".$db->doc.$result['anio']."_a/".$c_acuse[$fil]['direccion']."' data-caption='Correspondencia' target='nuevo'>";
									echo "<img src='".$db->doc.$result['anio']."_a/".$c_acuse[$fil]['direccion']."' alt='Correspondencia' >";
								echo "</a><br>";
							echo "</div>";
						}
					echo "</div>";
				echo "</div>";
				echo "</div>";
	echo "</div>";
?>
