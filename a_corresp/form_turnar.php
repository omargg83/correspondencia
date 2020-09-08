<?php
	require_once("db_.php");
	$personal=$db->personal();

	$id=$_REQUEST['id'];
	echo "<form id='form_turno' action='' data-lugar='a_corresp/db_' data-destino='a_corresp/editar' data-funcion='turnar' data-div='turnos'>";
		echo "<input  type='hidden' id='id' NAME='id' value='$id'>";
		echo "<div class='card'>";
			echo "<div class='card-header'>Turnos</div>";

			echo "<div class='card-body'>";
				echo "<div class='row' id='paraturnar'>";
					echo  "<div class='col-sm-5'>";
						echo "<label>Turnar a: </label>";
						echo "<select name='aperson' id='aperson' class='form-control'>";
						echo "<option value='' disabled selected style='color: silver;'>Seleccione una persona...</option>";
						$are=0;
							foreach($personal as $key){
								if ($are!=$key['idarea']){
									echo  "<optgroup label='".$key['area']."'>";
									$are=$key['idarea'];
								}
								echo '<option value="'.$key['idpersona'].'"';
								echo '>'.$key["nombre"].'</option>';
							}
						echo  "</select>";
					echo  "</div>";

					echo  "<div class='col-sm-5'>";
						echo "<label>Respuesta / Observaciones:</label>";
						echo  "<input type='text' class='form-control' id='observa2' NAME='observa2' value=''  placeholder='Observaciones personales.'>";
					echo  "</div>";

					echo  "<div class='col-sm-2'>";
						echo "<input type='checkbox' name='original' value='1'><b>Original</b>";
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
