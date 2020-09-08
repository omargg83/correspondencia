<?php
	require_once("db_.php");

	$id=$_REQUEST['id'];
	$idcargo=$_REQUEST['id2'];
	$idarea=$_REQUEST['id3'];

	if($idcargo>0){
		$cargox = $db->cargoedit($idcargo);
		$cargo=$cargox['cargo'];

		$sql="select * from personal where idcargo='".$cargox['parentid']."'";
		$sup=$db->general($sql);

		if(count($sup)>0){
			$superior=$sup[0]['idpersona'];
		}
		$itemtype=$cargox['itemtype'];
	}
	else{
		$idcargo=0;
		$cargo="";
		$superior="";
		$itemtype=0;
	}
?>

<div class='modal-header'>
	<h5 class='modal-title'>Agregar cargo</h5>
</div>
  <div class='modal-body' >
		<?php
			echo "<form id='form_comision' action='' data-lugar='a_personal/db_' data-funcion='guardar_cargo' data-destino='a_personal/editar' autocomplete='off'>";
			echo "<input type='hidden' id='id' NAME='id' value='$idcargo' class='form-control' required>";
			echo "<input type='hidden' id='idarea' NAME='idarea' value='$idarea' class='form-control' required>";
			echo "<input type='hidden' id='idpersona' NAME='idpersona' value='$id' class='form-control' required>";
		?>
		<p class='input_title'>Cargo:</p>
		<div class='form-group input-group'>
			<input type='text' id='cargox' NAME='cargox' placeholder='Cargo' size='50' autocomplete='OFF' value='<?php   echo $cargo; ?>' class='form-control' required>
		</div>

		<p class='input_title'>Superior:</p>
		<div class='form-group input-group'>

		<?php
			$per = $db->personal();
			echo "<select name='idsuperior' id='idsuperior' class='form-control'>";
			echo "<option value='' disabled selected style='color: silver;'>Seleccione...</option>";
				$arean="";
				$are=0;
				for($i=0;$i<count($per);$i++){
					if ($are!=$per[$i]['idarea']){
						echo  "<optgroup label='".$per[$i]['area']."'>";
						$are=$per[$i]['idarea'];
					}
					echo  "<option value=".$per[$i]['idpersona'];
					if ($per[$i]['idpersona']==$superior){
						echo  " selected ";
					}
					echo  ">".$per[$i]['nombre']."</option>";
				}
			echo  "</select>";
		?>
		</div>
		<?php
		echo "<div class='form-group input-group'>";
		echo '<input type="checkbox" name="itemtype" id="itemtype" value="1" ';
		if($itemtype==1){
			echo " checked";
		}
		echo "> Staff<br>";
		echo "</div>";
		?>

		<div class='btn-group'>
		<button class='btn btn-outline-secondary btn-sm' type='submit' id='acceso'><i class='far fa-save'></i>Aceptar</button>
		<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i>Cerrar</button>
		</div>
		</form>
  </div>
