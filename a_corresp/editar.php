<?php
require_once("db_.php");
$personal=$db->personal();
$id=$_REQUEST['id'];
$tipo=0;
$_SESSION['tmp']=$id;

if ($db->nivel_captura==1){
	$tipo=0;
}
else{
	$tipo=1;
	$lectura="disabled";
}
if (isset($_REQUEST['id2'])){
	$tipo=$_REQUEST['id2'];
}

/*
tipo 0: Editar
tipo 1: responder
tipo 2: observar
tipo 3: limitado
*/

$numero=$db->numero2();
$diferencia="";
$contestado="";
$folio="";
$numoficio="";
$fechaofi=date("d-m-Y");
$asunto="";
$lectura="";
$remitente="";
$cargo="";
$dependencia="";
$anexos="";
$frecibido=date("d-m-Y");
$hrecibido=date("H:i:s");
$fcaptura=date("d-m-Y");
$recibido=$_SESSION['idpersona'];
$capturo=$_SESSION['idpersona'];
$comentarios="";
$clasificacion="";
$comentarios="";
$urgente="";
$atencion="";
$conocimiento="";
$acuerdo="";
$oficio="";
$archivar="";
$texto="";

if($id>0){
	$result = $db->c_oficio($id);
	//$c_archivos = $db->c_archivos($id);
	$c_archivoc = $db->c_filecontesta($id);

	$numero=$result['numero'];
	$diferencia=$result['diferencia'];
	$contestado=$result['contestado'];
	$folio=$result['folio'];
	$numoficio=$result['numoficio'];

	$asunto=$result['asunto'];
	$remitente=$result['remitente'];
	$cargo=$result['cargo'];
	$dependencia=$result['dependencia'];
	$anexos=$result['anexos'];

	$fechaofi= fecha($result['fechaofi']);
	list($fecha,$hora)=explode(" ",$result['frecibido']);
	$frecibido= fecha($fecha);
	$hrecibido=$hora;

	$fcaptura= fecha($result['fcaptura']);
	$recibido=$result['recibido'];
	$capturo=$result['capturo'];
	$comentarios=$result['comentarios'];
	$clasificacion=$result['clasificacion'];
	$urgente=$result['urgente'];
	$atencion=$result['atencion'];
	$conocimiento=$result['conocimiento'];
	$acuerdo=$result['acuerdo'];
	$oficio=$result['oficio'];
	$archivar=$result['archivar'];
	$texto=$result['texto'];
}

if($tipo==0 or $tipo==1){
	echo "<div class='container'>";
}

/////////////////////////////////////////Actualización anita
$disabled="";
if ($id>0){
	$sql="SELECT idpersturna FROM yoficiosp	where idoficio='$id'";
	$row0 = $db->general($sql);
	$contar=count($row0);
	if ($contar>1){
		$disabled="disabled";
	}
	else{
		$disabled="";
	}
}

/////////////////////////////////////////Para verificar si tiene solicitud de turno
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
					echo "<button class='btn btn-outline-secondary btn-fill pull-left btn-sm' id='aprueba' title='Editar' onclick='aprueba_salida(".$key['id'].")'><i class='fas fa-user-check'></i></button>";
					echo "<button class='btn btn-outline-secondary btn-fill pull-left btn-sm' id='cancela' title='Editar' onclick='cancela_salida(".$key['id'].")'><i class='fas fa-user-times'></i></button>";
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

//////////////////////////////comienza encabezado
echo "<div class='card '>";
	echo "<div class='card-header '><b># ".$numero."</b> ";
		echo "(".$texto.")<br>";
		if($diferencia>15 and $contestado==0){
			echo "<span style='font-size:10px'> (".$diferencia." dias sin contestación) </span>";
		}
		if(strlen($folio)>1){
			echo "<span style='font-size:10px'> (Turnado de Jefatura)</span>";
		}
	echo "</div>";

////////////////////////////// Cuerpo del formulario
echo "<form id='form_corresp' action='' data-lugar='a_corresp/db_' data-destino='a_corresp/editar' data-funcion='guardar'>";
echo "<input  type='hidden' id='id' NAME='id' value='$id'>";
echo "<input  type='hidden' id='nivel' NAME='nivel' value='".$db->nivel_personal."'>";
echo "<div class='card-body'>";
	echo "<div class='row'>";
		echo  "<div class='col-sm-2'>";
			echo "<label>Num. de Oficio:</label>";
			if($tipo>0)
				echo "<br>".$numoficio;
			else
				echo "<input type='text' class='form-control' value='".$numoficio."' id='numoficio' name='numoficio' $lectura autocomplete=off required placeholder='# de oficio' $disabled>";
				echo "<div id='duplicado' class='flotante'></div>";
		echo "</div>";

		echo  "<div class='col-sm-2'>";
			echo "<label>F. del oficio:</label>";
			if($tipo>0)
			echo "<br>".$fechaofi;
			else
			echo "<input type='text' class='form-control fechaclass' value='$fechaofi' id='fechaofi' name='fechaofi' $lectura required $disabled>";
		echo "</div>";

		echo  "<div class='col-sm-2'>";
			echo "<label>Folio Jefatura:</label>";
			if($tipo>0)
				echo "<br>".$folio;
			else
				echo "<input type='text' class='form-control' value='".$folio."' id='folio' name='folio' $lectura placeholder='Folio de jefatura' $disabled>";
		echo "</div>";

		echo  "<div class='col-sm-4'>";
			echo "<label>Anexos:</label>";
			if($tipo>0)
			echo "<br>".$anexos;
			else
			echo "<input type='text' class='form-control' value='".$anexos."' id='anexos' name='anexos' $lectura placeholder='Anexos' $disabled>";
		echo "</div>";

		echo  "<div class='col-sm-2'>";
			echo "<label># interno: </label>";
			if($tipo>0)
				echo "<br>".$numero;
			else
				echo "<input type='text' class='form-control' value='".$numero."' id='numero' name='numero' $lectura placeholder='Interno' $disabled style='background-color:#f0c1a5'>";
		echo "</div>";

		if($db->nivel_personal==12){
			echo  "<div class='col-sm-12'>";
				echo "<label>Tema:</label>";
				echo "<input type='text' class='form-control' value='".$texto."' id='texto' name='texto' $lectura placeholder='Tema' $disabled>";
			echo "</div>";
		}


	echo "</div>";

	echo "<hr>";


	echo "<div class='row'>";
		echo  "<div class='col-sm-12'>";
			echo "<label>Asunto:</label>";
				echo "<textarea class='form-control' value='$asunto' id='asunto' name='asunto' $lectura rows='3' placeholder='Asunto del oficio'>".$asunto."</textarea>";
		echo "</div>";
	echo "</div>";


		echo "<div class='row'>";
		echo  "<div class='col-sm-6'>";
		echo "<label>Remitente:</label>";
		echo "<textarea id='remitente' class='form-control' name='remitente' row='1' autocomplete='off' style='height:40px;' $lectura placeholder='Remitente'>$remitente</textarea>";
		if($tipo==0){
			echo "<div id='remitente_sug' class='flotante'></div>";
		}
		echo "</div>";

		echo  "<div class='col-sm-3'>";
		echo "<label>Cargo:</label>";
		echo "<input type='text' class='form-control' value='".$cargo."' id='cargo' name='cargo' $lectura autocomplete=off placeholder='Cargo'>";
		echo "</div>";

		echo  "<div class='col-sm-3'>";
		echo "<label>Dependencia:</label>";
		echo "<input type='text' class='form-control' value='".$dependencia."' id='dependencia' name='dependencia' $lectura autocomplete=off placeholder='Dependencia'>";
		echo "</div>";
		echo "</div>";

	if($tipo==0){
		echo "<div class='row'>";
			echo  "<div class='col-sm-12'>";
				echo "<div class='row'>";
					echo "<div class='col-sm-4'>";
						echo "<label class='radio-inline'><i class='fas fa-radiation-alt'></i><input type='checkbox' id='urgente' name='urgente' value='1' $lectura "; if($urgente==1) { echo "checked";} echo "> Urgente</label><br>";
						echo "<label class='radio-inline'><i class='fas fa-exclamation-circle'></i><input type='checkbox' id='atencion' name='atencion' value='1' $lectura "; if($atencion==1) { echo "checked";} echo "> Para su atención</label>";
					echo "</div>";

					echo "<div class='col-sm-4'>";
						echo "<label class='radio-inline'><i class='far fa-eye'></i><input type='checkbox' id='conocimiento' name='conocimiento' value='1' $lectura "; if($conocimiento==1) { echo "checked";} echo "> Para su conocimiento</label><br>";
						echo "<label class='radio-inline'><i class='fas fa-users'></i><input type='checkbox' id='acuerdo' name='acuerdo' value='1' $lectura "; if($acuerdo==1) { echo "checked";} echo "> Acuerdo</label>";
					echo "</div>";

					echo "<div class='col-sm-4'>";
						echo "<label class='radio-inline'><i class='far fa-copy'></i><input type='checkbox' id='oficio' name='oficio' value='1' $lectura "; if($oficio==1) { echo "checked";} echo "> Contestar por oficio</label><br>";
						echo "<label class='radio-inline'><i class='far fa-folder-open'></i><input type='checkbox' id='archivar' name='archivar' value='1' $lectura "; if($archivar==1) { echo "checked";} echo "> Archivar</label>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";

		echo "<hr>";

		echo "<div class='row'>";
			echo  "<div class='col-sm-2'>";
				echo "<label for='frecibido'>F. de Recibido:</label>";
				echo "<input type='text' class='form-control fechaclass form-control-sm' value='".$frecibido."' id='frecibido' name='frecibido' $lectura $disabled>";
			echo "</div>";

			echo  "<div class='col-sm-2'>";
				echo "<label for='hrecibido'>H. de Recibido:</label>";
				echo "<input type='text' class='form-control form-control-sm' value='".$hrecibido."' id='hrecibido' name='hrecibido' $lectura $disabled>";
			echo "</div>";

			echo  "<div class='col-sm-4'>";
			echo "<label>Recibió:</label>";
			echo "<select id='recibido' name='recibido' class='form-control form-control-sm' $disabled>";
			$are=0;
			for($perx=0;$perx<count($personal);$perx++){
				if ($are!=$personal[$perx]['idarea']){
					echo  "<optgroup label='".$personal[$perx]['area']."'>";
					$are=$personal[$perx]['idarea'];
				}
				echo "<option value='".$personal[$perx]['idpersona']."'";if($recibido==$personal[$perx]['idpersona']){ echo " selected";}  echo ">";
				echo $personal[$perx]['nombre'];
				echo "</option>";
			}
			echo "</select>";
			echo "</div>";
		echo "</div>";
	}

	echo "</div>";
	echo "<div class='card-footer '>";
	echo "<div class='btn-group'>";
	if($tipo==0 or $tipo==1){
		if ($db->nivel_captura==1){
			echo "<button class='btn btn-outline-secondary btn-sm' type='submit'><i class='far fa-save'></i>Guardar</button>";
			if($id>0){
				echo "<button class='btn btn-outline-secondary btn-sm' type='button' onclick='escanear_e()'><i class='fas fa-scroll'></i>Escanear</button>";
			}
			if($id>0){
				echo "<button class='btn btn-outline-secondary btn-sm' id='imprime_papeleta' title='Imprimir' data-lugar='a_corresp/imprimir' data-tipo='1' data-id='$id'><i class='fas fa-print'></i>Papeleta</button>";
			}
		}
		if ($contestado==0 and $id>0){
			echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-toggle='modal' data-target='#myModal' onclick='responder_c()'><i class='fas fa-check-double'></i> Responder</button>";
		}
		if($id>0){
			echo "<button type='button' class='btn btn-outline-secondary btn-sm' onclick='turnar_c()'><i class='fas fa-user-friends'></i> Turnar</button>";
		}
		echo "<button class='btn btn-outline-secondary btn-sm' id='lista_area' data-lugar='a_corresp/lista'><i class='fas fa-undo'></i>Regresar</button>";
	}
	if($tipo==2 or $tipo==3){
		if($tipo==3){
			echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal' onclick='turnosol_entrada()'><i class='fas fa-chalkboard-teacher'></i>Solicitar turno</button>";
		}
		echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal'><i class='fas fa-undo-alt'></i>Cerrar</button>";
	}
	echo "</div>";
	echo "</div>";
echo "</form>";


if ($id>0){
	echo "<hr>";
	echo "<div class='card-header'>";
		echo "Turnos";
	echo "</div>";

	echo "<div class='card-body ' style='float:left;width:100%;height:200px;overflow: auto;border: 0px;' id='turnos'>";
	echo "</div>";

	if($tipo!=3){
		echo "<div class='card-header '>Documentos</div>";
			echo "<div class='card-body'>";
				echo "<div class='row'>";
					echo "<div class='baguetteBoxOne gallery' id='archivos'>";
					/*
						for($fil=0;$fil<count($c_archivos);$fil++){
							echo "<div style='border:.1px solid silver;float:left;margin:10px'>";

							echo "<a href='".$db->doc.$result['year']."/".$c_archivos[$fil]['direccion']."' data-caption='Correspondencia' target='nuevo'>";
							echo "<img src='".$db->doc.$result['year']."/".$c_archivos[$fil]['direccion']."' alt='Correspondencia'>";
							echo "</a><br>";

							if ($db->nivel_captura==1 and $tipo==0){
								echo "<button class='btn btn-outline-secondary btn-sm' title='Eliminar archivo'
								id='delfile_orden'
								data-ruta='".$db->doc.$result['year']."/".$c_archivos[$fil]['direccion']."'
								data-keyt='idfile'
								data-key='".$c_archivos[$fil]['idfile']."'
								data-tabla='yoficios_archivos'
								data-campo='file_asistencia'
								data-tipo='2'
								data-iddest='$id'
								data-divdest='trabajo'
								data-borrafile='1'
								data-dest='a_corresp/editar.php?id='
								><i class='far fa-trash-alt'></i></button>";
							}
							echo "</div>";
						}
						*/
					echo "</div>";
				echo "</div>";
			if ($db->nivel_captura==1 and $tipo==0){
				echo "<div class='btn-group'>";
					echo "<button class='btn btn-outline-secondary btn-sm' type='button' onclick='escanear_e()'><i class='fas fa-scroll'></i>Escanear</button>";
					echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-toggle='modal' data-target='#myModal' id='fileup_anexox' data-ruta='".$db->doc.$result['year']."' data-tabla='yoficios_archivos' data-campo='direccion' data-tipo='2' data-id='$id' data-keyt='idoficio' data-destino='a_corresp/editar' data-iddest='$id' data-ext='.jpg,.png' ><i class='fas fa-cloud-upload-alt'></i>Adjuntar</button>";
				echo "</div>";
			}
			echo "</div>";
	}

	if($id>0 and ($tipo==0 or $tipo==1)){


		echo "<div class='card-header '> Documentos de respuesta</div>";
			echo "<div class='card-body'>";
				echo "<div class='row' >";
					echo "<p><h6>Oficios de respuesta: este nuevo apartado es para conocer como fue respondido el oficio, al presionar el boton seleccionar apareceran los oficios emitidos por el area dentro de los cuales se deberá de seleccionar el oficio indicado o se puede subir el archivo directamente</h6>";
					echo "<div class='baguetteBoxOne gallery'>";
						for($fil=0;$fil<count($c_archivoc);$fil++){
							echo "<div style='border:.1px solid silver;float:left;margin:10px'>";
							if($c_archivoc[$fil]['tipo']==1){
								if(file_exists("../".$db->doc.$c_archivoc[$fil]['anio']."_s/".$c_archivoc[$fil]['direccion'])){
									echo "<a href='".$db->doc.$c_archivoc[$fil]['anio']."_s/".$c_archivoc[$fil]['direccion']."' data-caption='Correspondencia'>";
									echo "<img src='".$db->doc.$c_archivoc[$fil]['anio']."_s/".$c_archivoc[$fil]['direccion']."' alt='Correspondencia' >";
									echo "</a><br>";

									echo "<button class='btn btn-outline-secondary btn-sm' title='Eliminar archivo'
									id='delfile_orden'
									data-ruta='".$db->doc.$result['year']."_s/".$c_archivoc[$fil]['direccion']."'
									data-keyt='idfile'
									data-key='".$c_archivoc[$fil]['idfile']."'
									data-tabla='yoficios_archivosresp'
									data-campo='file_asistencia'
									data-tipo='2'
									data-iddest='$id'
									data-divdest='trabajo'
									data-borrafile='0'
									data-dest='a_corresp/editar.php?id='
									><i class='far fa-trash-alt'></i></button>";
								}
								else{
									echo "<a href='".$db->doc.$c_archivoc[$fil]['anio']."_a/".$c_archivoc[$fil]['direccion']."' data-caption='Correspondencia'>";
									echo "<img src='".$db->doc.$c_archivoc[$fil]['anio']."_a/".$c_archivoc[$fil]['direccion']."' alt='Correspondencia' >";
									echo "</a><br>";

									echo "<button class='btn btn-outline-secondary btn-sm' title='Eliminar archivo'
									id='delfile_orden'
									data-ruta='".$db->doc.$result['year']."_a/".$c_archivoc[$fil]['direccion']."'
									data-keyt='idfile'
									data-key='".$c_archivoc[$fil]['idfile']."'
									data-tabla='yoficios_archivosresp'
									data-campo='file_asistencia'
									data-tipo='2'
									data-iddest='$id'
									data-divdest='trabajo'
									data-borrafile='0'
									data-dest='a_corresp/editar.php?id='
									><i class='far fa-trash-alt'></i></button>";
								}
							}
							else{
								echo "<a href='".$db->doc.$result['year']."_r/".$c_archivoc[$fil]['direccion']."' data-caption='Correspondencia'>";
								echo "<img src='".$db->doc.$result['year']."_r/".$c_archivoc[$fil]['direccion']."' alt='Correspondencia' >";
								echo "</a><br>";

								echo "<button class='btn btn-outline-secondary btn-sm' title='Eliminar archivo'
								id='delfile_orden'
								data-ruta='".$db->doc.$result['year']."_r/".$c_archivoc[$fil]['direccion']."'
								data-keyt='idfile'
								data-key='".$c_archivoc[$fil]['idfile']."'
								data-tabla='yoficios_archivosresp'
								data-campo='file_asistencia'
								data-tipo='2'
								data-iddest='$id'
								data-divdest='trabajo'
								data-borrafile='1'
								data-dest='a_corresp/editar.php?id='
								><i class='far fa-trash-alt'></i></button>";
							}
							echo "</div>";
						}
					echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "<div class='card-footer'>";
				echo "<div class='btn-group'>";
				echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-toggle='modal' data-target='#myModal' id='fileup_respuesta' data-ruta='".$db->doc.$result['year']."_r' data-tabla='yoficios_archivosresp' data-campo='direccion' data-tipo='2' data-id='$id' data-keyt='idoficio' data-destino='a_corresp/editar' data-iddest='$id' data-ext='.jpg,.png,.pdf' ><i class='fas fa-cloud-upload-alt'></i>Subir</button>";
				echo "<button class='btn btn-outline-secondary btn-sm' data-toggle='modal' data-target='#myModal' onclick='oficioss()'><i class='fas fa-paperclip'></i>C. Entrada</button> ";
				echo "</div>";
			echo "</div>";
	}
}
if($tipo==0){
	echo "</div>";
}
?>
<script type="text/javascript">
	$(function() {
		var id=$("#id").val();
		fechas();
		$("#archivos").load("a_corresp/archivos.php?id="+id);
		$("#turnos").load("a_corresp/turnos.php?id="+id);
		baguetteBox.run('.baguetteBoxOne');
		if(vscan==""){
			vscan=window.setInterval("escaneo()",10000);
		}
	});
</script>
