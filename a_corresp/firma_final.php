<?php
	require_once("db_.php");
	$idpersona=$_REQUEST['idpersona'];
	$oficios=$_REQUEST['oficios'];
	$tipof=$_REQUEST['tipof'];

	echo "<form id='firma_corresp' action='' data-lugar='a_corresp/db_' data-funcion='firma_entrega' data-destino='a_personal/editar' autocomplete='off'>";
	if(strlen($oficios)>0){
		$sql="select * from yoficios where idoficio in ($oficios)";
		$per = $db->general($sql);
		echo "
		<div class='modal-header'>
			<h5 class='modal-title'>Firma</h5>
		</div>";
		echo "<div class='modal-body' >";

		echo "<input type='hidden' id='tipof' NAME='tipof' value='$tipof'>";
		echo "<input type='hidden' id='idturnado' NAME='idturnado' value='$idpersona' >";
		echo "<table class='table table-sm'>";
		echo "<tr>";

		echo "<th >-</b></th>";
		echo "<th >Interno</b></th>";
		echo "<th >Num.</b></th>";
		echo "<th >Fecha</b></th>";
		echo "<th >Remitente / Asunto</b></th>";

		echo "</tr>";

		for($i=0;$i<count($per);$i++){
			echo "<tr>";
			echo "<td>";
			echo $i+1;
			echo "</td>";
			echo "<td>";
			echo "<input type='checkbox' value='".$per[$i]['idoficio']."' id='par_firma_".$per[$i]['idoficio']."' name='par_firma_".$per[$i]['idoficio']."' checked disabled>";
			echo $per[$i]['numero'];
			echo "</td>";
			echo "<td>";
			echo $per[$i]['numoficio'];
			echo "</td>";

			list($anio,$mes,$dia)=explode("-",$per[$i]['fechaofi']);
			echo "<td><center>".$dia."-".$mes."-".$anio."</center></td>";
			echo "<td>";
				echo $per[$i]['remitente'];
			echo "</td>";

			echo "</tr>";
		}
		echo "</table>";
	}
	else{
		echo "<h4>Debe seleccionar algún oficio</h4>";
	}
	if($tipof=="entrada"){
		$per = $db->personal();
		echo "<div class='row'>";
			echo "<div class='col-6'>";
				echo "<label>Recibe:</label>";
				echo "<select id='firma_t' name='firma_t' class='form-control'>";
				$are=0;
				for($i=0;$i<count($per);$i++){
					if ($are!=$per[$i]['idarea']){
						echo  "<optgroup label='".$per[$i]['area']."'>";
						$are=$per[$i]['idarea'];
					}
					echo  "<option value='".$per[$i]['idpersona']."'";
					if ($per[$i]['idpersona']==$idpersona){
						echo  " selected ";
					}
					echo  ">".$per[$i]['nombre']."</option>";
				}
				echo "</select>";
			echo "</div>";
			echo "<div class='col-6'>";
				echo "<label>Contraseña:</label>";
				echo "<input class='form-control' placeholder='Contraseña' type='password'  id='contra' name='contra' required autocomplete='off'>";
			echo "</div>";
		echo "</div>";
	}
		echo "<div class='btn-group'>";
			echo "<button class='btn btn-outline-secondary btn-sm' type='button' onclick='firma_final()'><i class='fas fa-signature'></i>Firmar</button>";
			echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal'><i class='fas fa-times'></i>Cancelar</button>";
		echo "</div>";
		echo "<br>Nota: seleccionar la persona que recibe el oficio.";
	echo "</form>";
?>
