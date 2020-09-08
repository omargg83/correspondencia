<?php
	require_once("db_.php");

	$val="";
	$filtro=0;

	$c_listado = $db->c_todos();

		$contaor=1;
		echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
		echo "<h5><center>Todos los oficios</center></h5><hr>";
		echo "<table id='x_lista' class='display compact hover' style='font-size:12pt;'>";

		echo "<thead><tr>";
		echo "<th >#</b></th>";
		echo "<th>-</th>";
		echo "<th >Interno</b></th>";
		echo "<th >Num.</b></th>";
		echo "<th >Fecha</b></th>";
		echo "<th >Remitente / Asunto</b></th>";
		echo "</tr>";
		echo "</thead><tbody>";
		$prim=0;
		for($i=0;$i<count($c_listado);$i++){
			$varx="";
			if($c_listado[$i]['clasificacion']=='URGENTE'){ $varx="table-danger"; }
			if($c_listado[$i]['clasificacion']=='ATENCION'){ $varx="table-warning"; }
			if($c_listado[$i]['clasificacion']=='CONOCIMIENTO'){  $varx="table-info"; }
			if($c_listado[$i]['clasificacion']=='ACUERDO'){  $varx="table-dark"; }
			if($c_listado[$i]['clasificacion']=='OFICIO'){  $varx="table-primary"; }
			if($c_listado[$i]['clasificacion']=='ARCHIVAR'){  $varx="table-secondary"; }


				echo "<tr id=".$c_listado[$i]['idoficio']." class='edit-t $varx'>";

				echo "<td>";
				echo $i+1;
				echo "</td>";

				echo "<td>";
				echo "<button class='btn btn-outline-secondary btn-fill pull-left btn-sm' id='edit_corresp' title='Editar' data-lugar='a_corresp/editar'><i class='fas fa-pencil-alt'></i></i></button>";
				echo "</td>";

				echo "<td>";
				echo $c_listado[$i]['numero'];
				echo "</td>";

				echo "<td>".$c_listado[$i]['numoficio']."</td>";

				list($anio,$mes,$dia)=explode("-",$c_listado[$i]['fechaofi']);
				echo "<td><center>".$dia."-".$mes."-".$anio."</center></td>";

				echo "<td>";
					echo $c_listado[$i]['remitente']."<br>-";
					echo $c_listado[$i]['asunto'];
				echo "</td>";

				echo "</td>";



				echo "</tr>";
		}
		echo "</table><br>";

		echo "<table>
		<tr class='table-active'><td></td></tr>
		<tr class='table-primary'><td>CONTESTAR POR OFICIO</td></tr>
		<tr class='table-secondary'><td>ARCHIVAR</td></tr>
		<tr class='table-success'><td></td></tr>
		<tr class='table-danger'><td>URGENTE</td></tr>
		<tr class='table-warning'><td>ATENCION</td></tr>
		<tr class='table-info'><td>CONOCIMIENTO</td></tr>
		<tr class='table-light'><td></td></tr>
		<tr class='table-dark'><td>ACUERDO</td></tr>
		</table>";

		echo "</div>";

		/*
		echo "<div class='btn-group'>";
		echo "<a title='PDF' class='btn btn-outline-dark btn-sm' onclick='xajax_imprimir(\"3\",\"1\");'><i class='fa fa-file-pdf-o'></i></a>";
		echo "<a title='PDF' class='btn btn-outline-dark btn-sm' onclick='xajax_imprimir(\"3\",\"2\");'><i class='fa fa-file-excel-o'></i></a>";
		echo "</div>";
		*/
?>
<script>
	$(document).ready( function () {
		lista("x_lista");
	} );
</script>
