<?php
	require_once("db_.php");

	if (isset($_REQUEST['funcion'])){
		$nombre=$_REQUEST['funcion'];
	}

	if($db->nivel_personal==7 or $db->nivel_personal==0){
		$sql="select * from yoficiosp left outer join yoficios on yoficios.idoficio=yoficiosp.idoficio where idpersturna='".$_SESSION['superior']."' and contestado=0";
	}
	else{
		$sql="select * from yoficiosp left outer join yoficios on yoficios.idoficio=yoficiosp.idoficio where idpersturna='".$_SESSION['idpersona']."' and contestado=0";
	}
	$c_listado = $db->general($sql);

	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
		echo "<hr>";
		echo "<h5>OFICIOS PENDIENTES</h5>";
		echo "<hr>";
		echo "Nota: se incluyen todos los oficios pendientes donde tengo participación";
		echo "<div class='content table-responsive table-full-width' >";

			echo "<table class='table table-sm' style='font-size:10pt;' id='x_listaof'>";

			echo "<thead><tr>";
			echo "<th >-</th>";
			echo "<th >#numero</b></th>";
			echo "<th >Oficio</b></th>";
			echo "<th >Asunto</b></th>";
			echo "<th >Remitente</b></th>";
			echo "</tr>";
			echo "</thead><tbody>";
			$prim=0;
			foreach ($c_listado as $key) {
				echo "<tr id=".$key['idoficio']." class='edit-t'>";
				echo "<td>";
					echo "<button class='btn btn-outline-secondary btn-fill pull-left btn-sm' id='edit_corresp' title='Editar' data-lugar='a_corresp/editar'><i class='fas fa-pencil-alt'></i></button>";
				echo "</td>";
				echo "<td>";
				echo $key['numero'];
				echo "</td>";

				echo "<td>";
				echo $key['numoficio'];
				echo "</td>";

				echo "<td>";
				echo $key['asunto'];
				echo "</td>";

				echo "<td>";
				echo $key['remitente'];
				echo "</td>";
				echo "</tr>";


				echo "<tr>";
				echo "<td>";
				echo "</td>";

				echo "<td colspan=5>";
					echo "<ul style='font-size:10px;list-style:none'>";
						echo "<li>";
							echo "<div style='border-radius:5px;margin: 3px;border-left: 6px solid silver;'>";
								/////////////////////////////////////////
								echo "<div class='btn-group btn-group-sm'>";
									echo "<button type='button' ";
										if ($key['contesto']==1) { echo " class='btn btn-light btn-sm'"; }
										else { echo " class='btn btn-warning btn-sm'"; }
										echo ">";

										if ($key['contesto']==1) echo "<i class='far fa-grin'></i>";
										else echo "<i class='fa fa-info'></i>";


									echo "</button>";
								echo "</div>";

								$listado_edit = $db->personal_edit($key['idpersturna']);
								echo $listado_edit['estudio']." ". $listado_edit['nombre'];


								echo "<br>Observaciones: ".$key['observacionest'];
								echo "<br>Respuesta: ";
								if ($key['contesto']==0) echo "    <b>Pendiente </b>";
								else echo "    ".$key['contesta']." (".$key['fcontesta'].")</b>";
							////////////////////////////////////////////
							echo "</div>";
						echo "</li>";
					echo turno($key['idoficiop']);
					echo "</ul>";
				echo "<td>";
				echo "</tr>";

			}
			echo "</table><br>";


		echo "</div>";
	echo "</div>";

	function turno($idoficiop){
		global $db;
		echo "<ul style='font-size:10px;list-style:none'>";
			$sql="select * from yoficiosp where idofp='$idoficiop'";
			$c_listado = $db->general($sql);
			foreach ($c_listado as $key) {
				echo "<li>";
					echo "<div style='border-radius:5px;margin: 3px;border-left: 6px solid silver;'>";
						/////////////////////////////////////////
						echo "<div class='btn-group btn-group-sm'>";
							echo "<button type='button' ";
								if ($key['contesto']==1) { echo " class='btn btn-light btn-sm'"; }
								else { echo " class='btn btn-warning btn-sm'"; }
								echo ">";

								if ($key['contesto']==1) echo "<i class='far fa-grin'></i>";
								else echo "<i class='fa fa-info'></i>";


							echo "</button>";
						echo "</div>";

						$listado_edit = $db->personal_edit($key['idpersturna']);
						echo $listado_edit['estudio']." ". $listado_edit['nombre'];


						echo "<br>Observaciones: ".$key['observacionest'];
						echo "<br>Respuesta: ";
						if ($key['contesto']==0) echo "    <b>Pendiente </b>";
						else echo "    ".$key['contesta']." (".$key['fcontesta'].")</b>";
					////////////////////////////////////////////
					echo "</div>";
				echo "</li>";
				echo turno($key['idoficiop']);
			}
		echo "</ul>";
	}

/*
		$sql="select personal.nombre,count(idoficio) as total,area, personal.idpersona from yoficiosp
			left outer join personal on personal.idpersona=yoficiosp.idpersturna
			left outer join area on area.idarea=personal.idarea
			where contesto=0 group by idpersturna order by area.idarea asc";
		$c_listado = $db->general(id=".$key['idoficio']." class='edit-t $varx'$sql);


		echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
			echo "<div class='content table-responsive table-full-width' >";

				echo "<table class='table table-sm' style='font-size:10pt;' id='x_listaof'>";

				echo "<thead><tr>";
				echo "<th >-</b></th>";
				echo "<th >Persona</b></th>";
				echo "<th >Pendientes.</b></th>";
				echo "<th >Area.</b></th>";
				echo "<th >Numero.</b></th>";
				echo "<th >Asunto.</b></th>";
				echo "</tr>";
				echo "</thead><tbody>";
				$prim=0;
				for($i=0;$i<count($c_listado);$i++){
					echo "<tr>";

					echo "<td>";
					echo $i+1;
					echo "</td>";

					echo "<td>";
					echo $c_listado[$i]['nombre'];
					echo "</td>";

					echo "<td>".$c_listado[$i]['total']."</td>";
					echo "<td>".$c_listado[$i]['area']."</td>";
					echo "<td>";
					echo "</td>";
					echo "<td>";
					echo "</td>";
					echo "</tr>";

					if($db->nivel_personal==0){
						$sql="select * from yoficiosp left outer join yoficios on yoficios.idoficio=yoficiosp.idoficio where contesto=0 and idpersturna='".$c_listado[$i]['idpersona']."'";
						$oficios = $db->general($sql);
						foreach ($oficios as $row) {
							echo "<tr id=".$row['idoficio']." class='edit-t'>";

							echo "<td>";
							echo $i+1;
							echo "<button class='btn btn-outline-secondary btn-fill pull-left btn-sm' id='edit_corresp' title='Editar' data-lugar='a_corresp/editar'><i class='fas fa-pencil-alt'></i></button>";
							echo "</td>";

							echo "<td>";
							echo "</td>";

							echo "<td>";
							echo "</td>";

							echo "<td>".$c_listado[$i]['area']."</td>";

							echo "<td>";
								echo $row['numero'];
							echo "</td>";

							echo "<td>";
								echo $row['asunto'];
							echo "</td>";

							echo "</tr>";
						}
					}
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
*/
?>
