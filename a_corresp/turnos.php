<?php
	require_once("db_.php");
	$id=$_REQUEST['id'];

	$sql="SELECT idoficiop, original, fechturnado, fleido, nombre, file_fototh, contesto, fcontesta, contesta, observacionest,idpersturna FROM yoficiosp
	left outer join personal on personal.idpersona=yoficiosp.idpersturna
	where idoficio='$id' order by idoficiop asc limit 1";
	$row0 = $db->general($sql);
	echo "<ul style='font-size:10px;list-style:none'>";
		$hijos=0;
		$sql="SELECT original,fechturnado,fleido,idoficio,fcontesta,contesta,idofp,contesto,idoficiop,nombre,file_fototh, observacionest,idpersturna FROM yoficiosp left outer join personal on personal.idpersona=yoficiosp.idpersturna where idofp='".$row0[0]['idoficiop']."'";
		$nivel1 = $db->general($sql);
		if (count($nivel1)>0){
			$hijos=1;
		}
		echo "<li>";
			echo "<div style='border-radius:5px;margin: 3px;border-left: 6px solid silver;'>";
				echo "<div class='btn-group btn-group-sm'>";

					echo "<button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#myModal' onclick='datos_c(".$row0[0]['idoficiop'].")'>";
						echo '<i class="fas fa-search"></i>';
					echo "</button>";

					if($hijos==0 and $row0[0]['contesto']==1){			////////////////////borrar respuesta
						echo  "<button id='eliminar_respuesta'
						data-lugar='a_corresp/db_'
						data-destino='a_corresp/editar'
						data-id='".$row0[0]['idoficiop']."'
						data-funcion='borrarespuesta'
						data-div='turnos'
						data-iddest='$id'
						title='Borrar respuesta' class='btn btn-warning btn-sm' ><i class='fas fa-eraser'></i></button>";
					}

			  	echo "<button type='button' ";
						if ($row0[0]['contesto']==1) { echo " class='btn btn-light btn-sm'"; }
						else { echo " class='btn btn-warning btn-sm'"; }
						echo ">";
						if ($row0[0]['contesto']==1) echo "<i class='far fa-grin'></i>";
						else echo "<i class='fa fa-info'></i>";
						echo $row0[0]['nombre'];
					echo "</button>";
				echo "</div>";

				if($row0[0]['original']==1){
					echo "- (Original)";
				}
				echo "<br>Observaciones: ".$row0[0]['observacionest'];
				echo "<br>Respuesta: ";
				if ($row0[0]['contesto']==0) echo "<b>:</b>Pendiente";
				else echo "<b>:</b>".$row0[0]['contesta']."</b>";
			echo "</div>";
			if (count($nivel1)>0){
				turnados($nivel1,0,$id);
			}
		echo "</li>";
	echo "</ul>";


	function turnados($nivel1,$nivel,$id){
		global $db;
		$nivel++;
		if (count($nivel1)>0){
			foreach($nivel1 as $v2){
				$sql="SELECT original,fechturnado,fleido,fcontesta,contesta,idofp,idoficio,contesto,idoficiop,nombre,file_fototh, observacionest, idpersturna FROM yoficiosp left outer join personal on personal.idpersona=yoficiosp.idpersturna where idofp='".$v2['idoficiop']."'";
				$nivel2 = $db->general($sql);
				$hijos=0;

				if (count($nivel2)>0){
					$hijos=1;
				}
				echo "<ul style='font-size:10px;list-style:none'>";
					echo "<li>";
					echo "<div style='border-radius:5px;margin: 3px;border-left: 6px solid silver;'>";
						echo "<div class='btn-group btn-group-sm'>";
						echo "<button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#myModal' onclick='datos_c(".$v2['idoficiop'].")'>";
							echo '<i class="fas fa-search"></i>';
						echo "</button>";

							$sql="select * from yoficiosp where idoficiop='".$v2['idofp']."'";
							$rxp = $db->general($sql);
							if(($hijos==0 and $v2['contesto']==1 and $v2['idpersturna']==$_SESSION['idpersona']) or $db->nivel_personal==0){			////////////////////borrar respuesta
								echo  "<button type='button' id='eliminar_respuesta'
								data-lugar='a_corresp/db_'
								data-destino='a_corresp/editar'
								data-id='".$v2['idoficiop']."'
								data-funcion='borrarespuesta'
								data-div='turnos'
								data-iddest='$id'
								title='Borrar respuesta' class='btn btn-warning btn-sm' ><i class='fas fa-eraser'></i></button>";
							}

							if($hijos==0 and (($v2['contesto']==0 and ( $rxp[0]['idpersturna']==$_SESSION['idpersona'] or ($rxp[0]['idpersturna']==$_SESSION['superior'] and $db->nivel_personal==7))) or $db->nivel_personal==0))   {		////////////////////eliminar turno
								echo  "<button type='button' id='eliminar_turno' title='Eliminar turno' class='btn btn-danger btn-sm'
								data-lugar='a_corresp/db_'
								data-destino='a_corresp/editar'
								data-id='".$v2['idoficiop']."'
								data-funcion='borraturno'
								data-div='turnos'
								data-iddest='$id'
								><i class='far fa-trash-alt'></i></button>";
							}

					  	echo "<button type='button' ";
								if ($v2['contesto']==1) { echo " class='btn btn-light btn-sm'"; }
								else { echo " class='btn btn-warning btn-sm'"; }
								echo ">";

								if ($v2['contesto']==1) echo "<i class='far fa-grin'></i>";
								else echo "<i class='fa fa-info'></i>";
								echo $v2['nombre'];
							echo "</button>";
						echo "</div>";

						if($v2['original']==1){
							echo "- (Original)";
						}
						echo "<br>Observaciones: ".$v2['observacionest'];
						echo "<br>Respuesta: ";
						if ($v2['contesto']==0) echo "    <b>Pendiente </b>";
						else echo "    ".$v2['contesta']." (".$v2['fcontesta'].")</b>";
				echo "</div>";

						if (count($nivel2)>0){
							turnados($nivel2,$nivel,$id);
						}

					echo "</li>";
				echo "</ul>";
			}
		}
	}
?>
