<?php
	require_once("db_.php");

	$pd = $db->correspondencia();
	echo "<div class='container' >";
		echo "<div class='card'>";
		echo "<div class='card-header'>Imprimir correspondencia de salida</div>";
		echo "<div class='card-body'>";
			echo "<div class='row'>";
				echo "<div class='col-12'>";
					echo "<select class='form-control' id='idareap' name='idareap' multiple size='20' >";
					for($i=0;$i<count($pd);$i++){
						echo "<option value='".$pd[$i]['idoficio']."'";
						echo ">".$pd[$i]['numero']." - ".$pd[$i]['asunto']."</option>";
					}
					echo "</select>";
				echo "<div class='col-12'>";
				echo "<button class='btn btn-outline-secondary btn-sm' id='imprime_personal' title='Imprimir' data-lugar='a_corresps/imprimir' data-tipo='1' type='button'  data-valor='idareap'><i class='fas fa-print'></i>Imprimir</button>";
				echo "</div>";
			echo "</div>";

		echo "</div>";



	echo "</div>";

?>
