<?php
	require_once("db_.php");
	$id=$_REQUEST['id'];

	$tipo=0;
	if (isset($_REQUEST['id2'])){
		$tipo=$_REQUEST['id2'];
	}

	/*
	tipo 0: Editar
	tipo 1: responder
	tipo 2: observar
	tipo 3: limitado
	*/

	$personal = $db->personal();

	$lectura="";
	$fecha=date("d-m-Y");
	$documento='oficio';
	$destinatario="";
	$cargo="";
	$dependencia="";
	$asunto="";
	$idfirma="";
	$idausencia="";
	$idelabora="";
	$observaciones="";
	$contestado="0";
	$entrega=0;
	$cancelado=0;
	if($id>0){
	//	$result = $db->corregir($id);
		$result = $db->c_oficio($id);
//		$c_archivos = $db->c_archivos($id);
		$c_acuse = $db->c_acuse($id);
		$c_recepcion = $db->c_recepcion($id);

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

		if ($db->nivel_captura==1){
		}
		else{
			$lectura="disabled";
		}
	}
	else{
		$numero=$db->numero("yoficiosze","numero");
	}
	if($tipo==0 or $tipo==1){
		echo "<div class='container'>";
	}
	if($tipo==0 or $tipo==1){
		if($db->nivel_personal==7 or $db->nivel_personal==0){
			$tur=$db->ofturno($id);
			if(count($tur)>0){
				echo "<div class='card '>";
					echo "<div class='card-header'>";
						echo "El oficio tiene solicitud para turnos";
					echo "</div>";
					echo "<div class='body'>";
					echo "<table class='table>'>";
					foreach($tur as $key){
						$per=$db->personal_edit($key['idpersona']);
						echo "<tr>";
						echo "<div class='btn-group'>";
						echo "<button class='btn btn-outline-secondary btn-fill pull-left btn-sm' id='aprueba' title='Editar' onclick='aprueba_sal(".$key['id'].")'><i class='fas fa-user-check'></i></button>";
						echo "<button class='btn btn-outline-secondary btn-fill pull-left btn-sm' id='cancela' title='Editar' ><i class='fas fa-user-times'></i></button>";
						echo $per['nombre'];
						echo "</td>";
						echo "</tr>";
					}
					echo "</table>";
					echo "</div>";
				echo "</div></br>";
			}
		}
	}

		echo "<div class='card'>";
			echo "<form id='form_corress' action='' data-lugar='a_corresps/db_' data-destino='a_corresps/editar' data-funcion='guardar'>";
			echo "<input  type='hidden' id='id' NAME='id' value='$id'>";
			echo "<div class='card-header'># $numero</div>";
				echo "<div class='card-body'>";
					echo "<div class='row'>";
						echo  "<div class='col-sm-3'>";
							echo "<label for='numero'>Numero:</label>";
							if($tipo>0)
							echo "<br>".$numero;
							else
							echo "<input type='text' class='form-control' value='".$numero."' id='numero' name='numero' $lectura >";
						echo "</div>";

						echo  "<div class='col-sm-3'>";
							echo "<label for='correo'>Fecha:</label>";
							if($tipo>0)
							echo "<br>".fecha($fecha);
							else
							echo "<input type='text' class='form-control fechaclass' value='$fecha' id='fecha' name='fecha' $lectura>";
						echo "</div>";

						if($tipo>0){
							echo  "<div class='col-sm-3'>";
								echo "<label for='correo'>Documento:</label>";
								echo "<br>".$documento;
							echo "</div>";
						}
						else{
							echo  "<div class='col-sm-3'>";
								echo "<label><input type='radio' name='documento' id='documento'"; if ($documento=='oficio'){ echo "checked";} echo " value='oficio'> Oficio</label><br>";
								echo "<label><input type='radio' name='documento' id='documento'"; if ($documento=='memo'){ echo "checked";} echo " value='memo'> Memorandum</label>";
							echo "</div>";
							echo  "<div class='col-sm-3'>";
								echo "<label><input type='radio' name='documento' id='documento'"; if ($documento=='comision'){ echo "checked";} echo " value='comision'> Oficio de Comisión</label><br>";
								echo "<label><input type='radio' name='documento' id='documento'"; if ($documento=='circular'){ echo "checked";} echo " value='circular'> Oficio circular</label>";
							echo "</div>";
						}
					echo "</div>";

					echo "<div class='row'>";
						echo  "<div class='col-sm-6'>";
							echo "<label for='correo'>Destinatario:</label>";
							if($tipo>0)
							echo "<br>".$destinatario;
							else
							echo "<textarea id='destinatario_salida' class='form-control' name='destinatario_salida' row='1' autocomplete='off' style='height:40px;' $lectura>$destinatario</textarea>";
							echo "<div id='remitente_reg' class='flotante'></div>";
						echo "</div>";

						echo  "<div class='col-sm-3'>";
							echo "<label for='correo'>Cargo:</label>";
							if($tipo>0)
							echo "<br>".$cargo;
							else
							echo "<input type='text' class='form-control' value='".$cargo."' id='cargo' name='cargo' $lectura>";
						echo "</div>";

						echo  "<div class='col-sm-3'>";
							echo "<label for='correo'>Dependencia:</label>";
							if($tipo>0)
							echo "<br>".$dependencia;
							else
							echo "<input type='text' class='form-control' value='".$dependencia."' id='dependencia' name='dependencia' $lectura>";
						echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
						echo  "<div class='col-sm-12'>";
							echo "<label for='correo'>Asunto:</label>";
							if($tipo>0)
							echo "<br>".$asunto;
							else
							echo "<textarea class='form-control' value='$asunto' id='asunto' name='asunto' $lectura >".$asunto."</textarea>";
						echo "</div>";
					echo "</div>";

					echo "<div class='row'>";
						echo  "<div class='col-sm-4'>";
							echo "<label for='correo'>Firma:</label>";
							echo "<select id='idfirma' name='idfirma' class='form-control' $lectura>";
							$are=0;
							for($perx=0;$perx<count($personal);$perx++){
								if ($are!=$personal[$perx]['idarea']){
									echo  "<optgroup label='".$personal[$perx]['area']."'>";
									$are=$personal[$perx]['idarea'];
								}
								echo "<option value='".$personal[$perx]['idpersona']."'";if($idfirma==$personal[$perx]['idpersona']){ echo " selected";}  echo ">";
								echo $personal[$perx]['nombre'];
								echo "</option>";
							}
							echo "</select>";
						echo "</div>";

						echo  "<div class='col-sm-4'>";
							echo "<label for='correo'>Firma:</label>";
							echo "<select id='idausencia' name='idausencia' class='form-control' $lectura>";
							echo "<option value=''";if($idfirma==""){ echo " selected";}  echo ">---</option>";
							$are=0;
							for($perx=0;$perx<count($personal);$perx++){
								if ($are!=$personal[$perx]['idarea']){
									echo  "<optgroup label='".$personal[$perx]['area']."'>";
									$are=$personal[$perx]['idarea'];
								}
								echo "<option value='".$personal[$perx]['idpersona']."'";if($idausencia==$personal[$perx]['idpersona']){ echo " selected";}  echo ">";
								echo $personal[$perx]['nombre'];
								echo "</option>";
							}
							echo "</select>";
						echo "</div>";

						echo  "<div class='col-sm-4'>";
							echo "<label for='correo'>Generó:</label>";
							echo "<select id='idelabora' name='idelabora' class='form-control' $lectura>";
							$are=0;
							for($perx=0;$perx<count($personal);$perx++){
								if ($are!=$personal[$perx]['idarea']){
									echo  "<optgroup label='".$personal[$perx]['area']."'>";
									$are=$personal[$perx]['idarea'];
								}
								echo "<option value='".$personal[$perx]['idpersona']."'";if($idelabora==$personal[$perx]['idpersona']){ echo " selected";}  echo ">";
								echo $personal[$perx]['nombre'];
								echo "</option>";
							}
							echo "</select>";
						echo "</div>";

					echo "</div>";

					echo "<div class='row'>";
						echo  "<div class='col-sm-12'>";
							echo "<label for='otra'>Observaciones:</label>";
							if($tipo>0)
							echo "<br>".$observaciones;
							else
							echo "<textarea id='observaciones' name='observaciones' rows='1' cols='30' placeholder='Escriba aqui las observaciones' class='form-control' $lectura>".$observaciones."</textarea>";
						echo "</div>";
					echo "</div>";
				echo "</div>";

				echo "<div class='card-footer'>";
					echo "<div class='btn-group'>";
					if($tipo==0){
						if ($db->nivel_captura==1){
							echo "<button class='btn btn-outline-secondary btn-sm' type='submit'><i class='far fa-save'></i>Guardar</button>";
							if($id>0){
								echo "<button class='btn btn-outline-secondary btn-sm' type='button' onclick='escanear()'><i class='fas fa-scroll'></i>Escanear</button>";
								if ($cancelado==0){
									echo "<button type='button' class='btn btn-outline-secondary btn-danger btn-sm' onclick='cancelado_salida()'><i class='far fa-thumbs-down'></i> Cancelar</button>";
								}
								else{
									echo "<button type='button' class='btn btn-outline-secondary btn-sm' onclick='descancelado_salida()'><i class='far fa-thumbs-up'></i> Descancelar</button>";
								}
							}
						}
						if($id>0){
							echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_cargo' data-id='$id' data-lugar='a_corresps/form_turnar' title='Cambiar cargo'><i class='fas fa-user-friends'></i> Turnar</button>";
						}
						if($id>0){
							if ($db->nivel_captura==1){
								if($entrega==0){
									echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='envia_of'><i class='fas fa-file-upload'></i> Envia</button>";
								}
								else{
									echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='recibe_of'><i class='fas fa-file-download'></i> Recibe</button>";
								}
							}
						}
						if($id>0){
							if($contestado==0){
								echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-toggle='modal' data-target='#myModal' onclick='respondesalida()'><i class='fas fa-suitcase'></i> Recepcion</button>";
								echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='marcar_oficios'><i class='far fa-calendar-check'></i> Marcar</button>";
							}
							else{
								echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='desmarcar_oficio'><i class='far fa-calendar-check'></i> Desmarcar</button>";
							}
						}
						echo "<button class='btn btn-outline-secondary btn-sm' id='lista_area' data-lugar='a_corresps/lista'><i class='fas fa-undo'></i>Regresar</button>";
					}
					else{
						echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal' onclick='turnosalidasol()'><i class='fas fa-chalkboard-teacher'></i>Solicitar turno</button>";
						echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal'><i class='fas fa-undo-alt'></i>Cerrar</button>";
					}

					echo "</div>";
				echo "</div>";
				echo "</form>";

		if($tipo==0){
			echo "<div class='card-header'>Turnos</div>";
			echo "<div class='card-body' style='float:left;width:100%;max-height:400px;overflow: auto;border: 0px;'  id='turnos'>";
			echo "</div>";
		}

		if($id>0 and $tipo==0){
				echo "<div class='card-header'>Documento</div>";
				echo "<div class='card-body'>";
					echo "<div class='row'>";
						echo "<div class='baguetteBoxOne gallery' id='archivos'>";
						/*
							for($fil=0;$fil<count($c_archivos);$fil++){
								echo "<div style='border:.1px solid silver;float:left;margin:10px'>";
									echo "<a href='".$db->doc.$result['anio']."_s/".$c_archivos[$fil]['direccion']."' data-caption='Correspondencia' target='nuevo'>";
										echo "<img src='".$db->doc.$result['anio']."_s/".$c_archivos[$fil]['direccion']."' alt='Correspondencia' >";
									echo "</a><br>";

									if ($db->nivel_captura==1){
										echo "<button class='btn btn-outline-secondary btn-sm' title='Eliminar archivo'
										id='delfile_orden'
										data-ruta='".$db->doc.$result['anio']."_s/".$c_archivos[$fil]['direccion']."'
										data-keyt='idarchivo'
										data-key='".$c_archivos[$fil]['idarchivo']."'
										data-tabla='yoficiosze_archivos'
										data-campo='direccion'
										data-tipo='2'
										data-iddest='$id'
										data-divdest='trabajo'
										data-borrafile='1'
										data-dest='a_corresps/editar.php?id='
										><i class='far fa-trash-alt'></i></button>";
									}
								echo "</div>";
							}
							*/
						echo "</div>";
					echo "</div>";

					if ($db->nivel_captura==1){
						echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-toggle='modal' data-target='#myModal' id='fileup_anexo' data-ruta='".$db->doc.$result['anio']."_s' data-tabla='yoficiosze_archivos' data-campo='direccion' data-tipo='2' data-id='$id' data-keyt='idoficio' data-destino='a_corresps/editar' data-iddest='$id' data-ext='.jpg,.png' ><i class='fas fa-cloud-upload-alt'></i>Imagen</button>";
					}
				echo "</div>";

				echo "<div class='card-header'>Recepción del documento</div>";
				echo "<div class='card-body'>";
					echo "<table class='table table-sm'>";
					echo "<tr><th>-</th><th>Recibió</th><th>Lugar</th><th>Fecha</th><th>Observaciones</th></tr>";
					for($perx=0;$perx<count($c_recepcion);$perx++){
						echo "<tr id=".$c_recepcion[$perx]['idrecibir']." class='edit-t'>";
						echo "<td>";
							if($contestado==0){
								echo "<button class='btn btn-outline-secondary btn-sm' id='eliminar_data' data-lugar='a_corresps/db_' data-destino='a_corresps/editar' data-id='".$c_recepcion[$perx]['idrecibir']."' data-funcion='borrarentrega' data-div='trabajo' data-iddest='$id'><i class='far fa-trash-alt'></i></i></button>";
							}
						echo "</td>";

						echo "<td>";
							echo $c_recepcion[$perx]['nombre'];
						echo "</td>";

						echo "<td>";
							echo $c_recepcion[$perx]['lugar'];
						echo "</td>";

						echo "<td>";
							$Weddingdate = new DateTime($c_recepcion[$perx]['fecha']);
							echo $Weddingdate->format('d-m-Y');
						echo "</td>";

						echo "<td>";
							echo $c_recepcion[$perx]['observaciones'];
						echo "</td>";

						echo "</tr>";
					}
					echo "</table>";
				echo "</div>";

				echo "<div class='card-header'>Acuse</div>";
				echo "<div class='card-body' style='float:left;width:100%;max-height:400px;overflow: auto;border: 0px;'  id='acuse'>";
				///////////////////////////////////////////////
				echo "<div class='row'>";
					echo "<div class='baguetteBoxOne gallery'>";
						for($fil=0;$fil<count($c_acuse);$fil++){
							echo "<div style='border:.1px solid silver;float:left;margin:10px'>";
								echo "<a href='".$db->doc.$result['anio']."_a/".$c_acuse[$fil]['direccion']."' data-caption='Correspondencia' target='nuevo'>";
									echo "<img src='".$db->doc.$result['anio']."_a/".$c_acuse[$fil]['direccion']."' alt='Correspondencia' >";
								echo "</a><br>";

								//if ($db->nivel_captura==1){
									echo "<button class='btn btn-outline-secondary btn-sm' title='Eliminar archivo'
									id='delfile_orden'
									data-ruta='".$db->doc.$result['anio']."_a/".$c_acuse[$fil]['direccion']."'
									data-keyt='id'
									data-key='".$c_acuse[$fil]['id']."'
									data-tabla='yoficiosze_archivosresp'
									data-campo='direccion'
									data-tipo='2'
									data-iddest='$id'
									data-divdest='trabajo'
									data-borrafile='1'
									data-dest='a_corresps/editar.php?id='
									><i class='far fa-trash-alt'></i></button>";
								//}
							echo "</div>";
						}
					echo "</div>";
				echo "</div>";
				echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-toggle='modal' data-target='#myModal' id='fileup_acuse'
				data-ruta='".$db->doc.$result['anio']."_a' data-tabla='yoficiosze_archivosresp' data-campo='direccion' data-tipo='2' data-id='$id' data-keyt='idoficio'
				data-destino='a_corresps/editar' data-iddest='$id' data-ext='.jpg,.png' ><i class='fas fa-cloud-upload-alt'></i>Imagen</button>";
				///////////////////////////////////////////////
				echo "</div>";
		}
	echo "</div>";
?>
	<script>
		$(function() {
			salidac();
			fechas();
			var id=$("#id").val();
			if(id>0){
				$("#turnos").load("a_corresps/turnos.php?id="+id);
				$("#archivos").load("a_corresps/archivos.php?id="+id);
			}
			if(vscan==""){
				vscan=window.setInterval("escan_salida()",10000);
			}
		});
	</script>
