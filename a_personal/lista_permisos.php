<?php
	require_once("db_.php");
	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
		echo "<div class='row'>";
			echo "<div class='col-sm-3'>";
				echo "<label for='prof'>Modulo:</label>";
				echo "<select id='aplicacion_per' name='aplicacion_per' class='form-control'>";
				echo $db->modulos();
				echo "</select>";
			echo "</div>";
			echo "<div class='col-sm-3'>";
			echo "</div>";
		echo "</div>";
		echo "<div id='permisos'>";
		echo "</div>";
	echo "</div>";
?>
