<?php
	require_once("db_.php");
	$val="";
	$filtro=0;
	$c_listado = $db->c_listado();

		$contaor=1;
		echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
			echo "<div class='content table-responsive table-full-width' >";
				echo "<h5><center>Oficios pendientes del area</center></h5><hr>";
				echo "<table id='x_lista' class='display compact hover' style='font-size:12pt;'>";

				echo "<thead><tr>";
				echo "<th >#</b></th>";
				echo "<th >-</b></th>";
				echo "<th >Numero</b></th>";
				echo "<th >Fecha</b></th>";
				echo "<th >Acuse</th>";
				echo "<th >Num.</b></th>";
				echo "<th >Remitente / Asunto</b></th>";

				echo "</tr>";
				echo "</thead><tbody>";
				$prim=0;
				for($i=0;$i<count($c_listado);$i++){
					$varx="";
					if ($c_listado[$i]['documento']=='oficio') {
						$bgcolor='';
						$tipx="Oficio";
					}
					if ($c_listado[$i]['documento']=='memo') {
						$bgcolor='';
						$tipx="Memorandum";
					}
					if ($c_listado[$i]['documento']=='comision') {
						$bgcolor='';
						$tipx="Oficio de Comisión";
					}
					if ($c_listado[$i]['documento']=='circular') {
						$bgcolor='';
						$tipx="Oficio circular";
					}


						echo "<tr id=".$c_listado[$i]['idoficio']." class='edit-t $varx'>";
						echo "<td>";
						echo $i;
						echo "</td>";

						echo "<td>";
						echo "<button class='btn btn-outline-secondary btn-sm' id='edit_corresp' title='Editar' data-lugar='a_corresps/editar'><i class='fas fa-pencil-alt'></i></i></button>";
						echo "</td>";

						echo "<td>";
						echo $c_listado[$i]['numero'];
						echo "</td>";

						echo "<td>".$c_listado[$i]['fecha']."</td>";
						echo "<td bgcolor='$bgcolor'>";
						echo $tipx;
						echo "</td>";

						echo "<td>";
						echo "<b>-".$c_listado[$i]['destinatario']."</b> ";
						echo $c_listado[$i]['cargo']." ";
						echo $c_listado[$i]['dependencia'];
						echo "</td>";

						echo "<td>";
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
		echo "</div>";

?>
<script>
	$(document).ready( function () {
		lista("x_lista");
	} );
</script>
