<?php
	require_once("db_.php");
	$nombre="";
	$valor="";
	if (isset($_REQUEST['funcion'])){
		$nombre=$_REQUEST['funcion'];
		$valor=$_REQUEST['valor'];
	}
	$pd = $db->plantilla($valor);
	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br><h5>Lista de personal</h5><hr>";
?>
		<div class="content table-responsive table-full-width">
			<table class="table-sm display compact hover" id="x_lista">
			<thead>
			<th>#</th>
			<th>-</th>
			<th>Foto</th>
			<th>Nombre</th>
			<th>Area</th>
			</tr>
			</thead>
			<tbody>
			<?php
				for($i=0;$i<count($pd);$i++){
					echo "<tr id=".$pd[$i]['idpersona']." class='edit-t'>";
					echo "<td>";
					echo $i+1;
					echo "</td>";
					echo "<td>";

					echo "<div class='btn-group'>";
					echo "<button class='btn btn-outline-secondary btn-sm' id='edit_persona' title='Editar' data-lugar='a_personal/editar'><i class='fas fa-pencil-alt'></i></button>";

					echo "</div>";
					echo "</td>";
					echo "<td>";
					echo "<img src='".$db->doc.trim($pd[$i]["file_foto"])."' width='25px'>";
					echo "</td>";
					echo "<td>".$pd[$i]["nombre"]." (".$pd[$i]["estudio"].")</td>";
					echo  "<td>".$pd[$i]['area']."</td>";
					echo "</tr>";
				}
			?>

			</tbody>
			</table>
		</div>
	</div>
