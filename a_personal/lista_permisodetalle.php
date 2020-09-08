<?php
	require_once("db_.php");
	$id=$_REQUEST['id'];

	$sql="select personal_permiso.nombre, personal_permiso.nivel, personal_permiso.acceso, personal_permiso.captura, personal_permiso.idpermiso, personal.nombre as personax, area.area from personal_permiso
	left outer join personal on personal.idpersona=personal_permiso.idpersona
	left outer join area on area.idarea=personal.idarea
	where personal_permiso.nombre='$id' order by personal_permiso.nivel desc";
	$pd = $db->general($sql);
	echo "<table class='table table-sm' id='x_lista'>";
	echo "<thead><tr><th>#</th><th>#</th><th>Persona</th><th>Nivel</th><th>Acceso</th><th>Captura</th><th>Area</th></tr></thead>";
	echo "<tbody>";
	for($i=0;$i<count($pd);$i++){
		echo "<tr id=".$pd[$i]['idpermiso']." class='edit-t'>";
		echo "<td>";
		echo $i+1;
		echo "</td>";
		echo "<td>";

		echo "<div class='btn-group'>";
		echo "<button class='btn btn-outline-secondary btn-sm' id='eliminar_permiso' data-lugar='a_personal/db_' data-id='".$pd[$i]['idpermiso']."' data-funcion='borrapermiso'
		data-destino='a_personal/lista_permisodetalle' data-iddest='$id' data-div='permisos'><i class='far fa-trash-alt'></i></i></button>";
		echo "</div>";
		echo "</td>";

		echo "<td>".$pd[$i]["personax"]."</td>";
		echo  "<td>".$db->nivelx($pd[$i]['nivel'])."</td>";
		echo  "<td>".$pd[$i]['acceso']."</td>";
		echo  "<td>".$pd[$i]['captura']."</td>";
		echo  "<td>".$pd[$i]['area']."</td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
?>
<script>
	$(document).ready( function () {
		lista("x_lista");
	});
</script>
