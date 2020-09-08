<?php
	require_once("db_.php");

	$personal = new Personal();
	$pd = $db->cargos();

	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
?>
		<div class="content table-responsive table-full-width">
			<table class="table-sm display compact hover" id="x_lista">
			<thead>
			<th>#</th>
			<th>-</th>
			<th>Cargo</th>
			<th>Persona</th>
			</tr>
			</thead>
			<tbody>
			<?php
				for($i=0;$i<count($pd);$i++){
					echo "<tr id=".$pd[$i]['id']." class='edit-t'>";
					echo "<td>";
					echo $i+1;
					echo "</td>";
					echo "<td>";

					echo "<div class='btn-group'>";
					//echo "<button class='btn btn-outline-secondary btn-sm' id='edit_comision' title='Editar' data-lugar='a_personal/editar'><i class='fas fa-pencil-alt'></i></button>";
					// echo "<button class='btn btn-outline-secondary btn-sm' id='eliminar_cargo' data-lugar='a_personal/personal_db' data-destino='a_personal/lista_cargos' data-id='".$pd[$i]['id']."' data-funcion='borrar_cargo' data-div='trabajo'><i class='far fa-trash-alt'></i></i></button>";

					echo "</div>";
					echo "</td>";
					echo "<td>".$pd[$i]["cargo"]."</td>";
					echo "<td>".$pd[$i]["nombre"]."</td>";

					echo "</tr>";
				}
			?>

			</tbody>
			</table>
		</div>
	</div>

<script>
	$(document).ready( function () {
		lista("x_lista");
	} );
</script>
