<?php
	require_once("db_.php");
	$id=$_REQUEST['id'];
	echo "<div class='content table-responsive table-full-width'>";
		echo "<table class='table table-sm'>";
		echo "<thead><tr><th>-</th>";
		echo "<th>Aplicación</th><th>Acceso</th><th>Nivel</th><th>Captura</th>";
		echo "</tr></thead><tbody>";
		$sql="select * from personal_permiso where idpersona='$id' order by nombre";
		$row=$db->general($sql);

		for($i=0;$i<count($row);$i++){
			echo "<tr>";
			echo "<td>";
			echo "<a id='eliminar_permiso' title='Eliminar' class='btn btn-outline-secondary btn-sm' id='eliminaper'
				data-lugar='a_personal/db_'
				data-destino='a_personal/form_permisos'
				data-id='".$row[$i]['idpermiso']."'
				data-funcion='borrapermiso'
				data-div='permisos'
				data-iddest='$id'>";

			echo  "<i class='far fa-trash-alt'></i></a>";
			echo "</td>";
			echo "<td>";
			echo $row[$i]['nombre'];
			echo "</td>";
			echo "<td><center>";
			echo $row[$i]['acceso'];
			echo "</td>";
			echo "<td><center>";
			echo $db->nivelx($row[$i]['nivel']);
			echo "</td>";
			echo "<td><center>";
			echo $row[$i]['captura'];
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
	echo "</div>";
?>
