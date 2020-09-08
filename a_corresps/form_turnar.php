<?php
	require_once("db_.php");
	$personal=$db->personal();

	$id=$_REQUEST['id'];
	echo "<form id='form_turno' action='' data-lugar='a_corresps/db_' data-destino='a_corresps/turnos' data-funcion='turnar' data-div='turnos' data-iddest='$id'>";
		echo "<input  type='hidden' id='id' NAME='id' value='$id'>";
		echo "<div class='card'>";
			echo "<div class='card-header'>Turnos</div>";

			echo "<div class='card-body'>";
				echo "<div class='row' id='paraturnar'>";
					echo  "<div class='col-sm-12'>";
						echo "<label>Turnar a: </label>";
						echo "<select name='aperson' id='aperson' class='form-control'>";
						echo "<option value='' disabled selected style='color: silver;'>Seleccione una persona...</option>";
						$are=0;
							for($i=0;$i<count($personal);$i++){
								if ($are!=$personal[$i]['idarea']){
									echo  "<optgroup label='".$personal[$i]['area']."'>";
									$are=$personal[$i]['idarea'];
								}

								echo '<option value="'.$personal[$i]['idpersona'].'"';
								echo '>'.$personal[$i]["nombre"].'</option>';
							}
						echo  "</select>";
					echo  "</div>";
				echo  "</div>";
			echo "</div>";
			echo "<div class='card-footer'>";
				echo  "<div class='col-sm-12'>";
					echo "<div class='btn-group'>";
						echo "<button class='btn btn-outline-secondary btn-sm' type='submit'><i class='fa fa-child'></i>Turnar</button>";
						echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal'><i class='fas fa-times'></i>Cancelar</button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";

		echo "</div>";

		echo "</div>";


	echo "</form>";
?>
