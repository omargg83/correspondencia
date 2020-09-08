<?php
	require_once("db_.php");

	$id=$_REQUEST['id'];

	echo "<form id='form_respuesta' data-lugar='a_corresp/db_' data-destino='a_corresp/editar' data-funcion='responder'>";
		echo "<input  type='hidden' id='id' NAME='id' value='$id'>";
		echo "<div class='card'>";
			echo "<div class='card-header'>Respuesta</div>";
			echo "<div class='card-body'>";
				echo "<div class='row'>";
					echo  "<div class='col-sm-12'>";
						echo "<label for='clasx'>Respuesta:</label>";
						echo "<TEXTAREA class='form-control' id='respuesta' Name='respuesta' placeholder='Escriba aqui la respuesta al oficio...' required></TEXTAREA>";
					echo "</div>";
				echo "</div>";

					echo "<div class='row'>";
						echo  "<div class='col-sm-3'>";
							$fecha=date("Y-m-d");
							list($anyo,$mes,$dia) = explode("-",$fecha);
							echo "<label for='fecharesp'>Fecha de respuesta</label>";
							echo  "<input  class='form-control' class='form-control' type='text' id='fecharesp' NAME='fecharesp' value='$dia-$mes-$anyo'  placeholder='Fecha' >";
						echo "</div>";

						echo  "<div class='col-sm-3'>";
							$hora=date("H:i:s");
							echo "<label for='fecharesp'>Hora de respuesta</label>";
							echo  "<input  class='form-control' class='form-control' type='time' id='horaresp' NAME='horaresp' value='$hora'  placeholder='Hora' >";
						echo "</div>";

						if($db->nivel_personal==7){ 			////////////////////////////secretarias
							$sql="select personal.idarea,personal.nombre,personal.idpersona from yoficiosp left outer join personal on personal.idpersona=yoficiosp.idpersturna
								where idoficio='$id' and personal.idarea='".$_SESSION['idarea']."' and yoficiosp.contesto=0";
						}
						else if($db->nivel_personal==0){		////////////////////////////Admin
							$sql="select personal.idarea,personal.nombre,personal.idpersona from yoficiosp left outer join personal on personal.idpersona=yoficiosp.idpersturna
								where idoficio='$id' and yoficiosp.contesto=0";
						}
						else{
							$sql="select personal.idarea,personal.nombre,personal.idpersona from yoficiosp left outer join personal on personal.idpersona=yoficiosp.idpersturna
								where idoficio='$id' and yoficiosp.contesto=0 and yoficiosp.idpersturna='".$_SESSION['idpersona']."'";
						}

						$otras = $db->general($sql);
						if(count($otras)>0){
							echo  "<div class='col-sm-6'>";
								echo "<label for='idcontestado'>Contestar por:</label>";
								echo  "<select name='idcontestado' id='idcontestado' class='form-control'>";

								for($i=0;$i<count($otras);$i++){
									echo '<option value="'.$otras[$i]['idpersona'].'"';
									echo '>'.$otras[$i]["nombre"].'</option>';
								}
								echo  "</select>";
							echo "</div>";

							echo  "<div class='col-sm-12'>";
								echo "<div class='btn-group'>";
									echo "<button class='btn btn-outline-secondary btn-sm' type='submit'><i class='fa fa-check'></i>Responder</button>";
									echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal'><i class='fas fa-times'></i>Cancelar</button>";
								echo "</div>";
							echo "</div>";
						}
					echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</form>";

?>
