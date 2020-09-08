<?php
	$id=$_REQUEST['id'];
	echo "<form id='form_agrega' action='' data-lugar='a_corresps/db_' data-destino='a_corresps/editar' data-funcion='agregaresp'>";
	echo "<input  type='hidden' id='id' NAME='id' value='$id'>";
	echo "<div class='card-header'>Recepción de oficio</div>";
		echo "<div class='card-body'>";
			echo "<div class='row'>";
				echo  "<div class='col-sm-4'>";
					echo "<label>Recibió:</label>";
					echo "<input type='text' id='recibio' name='recibio' class='form-control' value='' placeholder='Nombre de la persona que recibió el oficio' required>";
				echo "</div>";

				echo  "<div class='col-sm-4'>";
					echo "<label>Lugar</label>";
					echo "<input type='text' id='lugar' name='lugar' class='form-control' value='' placeholder='Lugar de entrega' required>";
				echo "</div>";

				echo  "<div class='col-sm-4'>";
					echo "<label>Fecha de entrega:</label>";
					$fecha=date("d-m-Y");
					echo "<input type='text' id='frecibio' name='frecibio' class='form-control' value='$fecha' placeholder='fecha' required>";
				echo "</div>";
			echo "</div>";

			echo "<div class='row'>";
				echo  "<div class='col-sm-12'>";
					echo "<label>Observaciones:</label>";
					echo "<textarea id='observa' name='observa' placeholder='Observaciones de entrega' class='form-control'></textarea>";
				echo "</div>";

			echo "</div>";
		echo "</div>";

		echo "<div class='card-footer'>";
				echo  "<div class='col-sm-12'>";
					echo "<div class='btn-group'>";
						echo "<button class='btn btn-outline-secondary btn-sm' type='submit'><i class='fas fa-plus'></i>Agregar</button>";
						echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-dismiss='modal'><i class='fas fa-times'></i>Cancelar</button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
	echo "</div>";
	echo "</form>";
?>

<script>
	$(function() {
		respuestac();
	});
</script>
