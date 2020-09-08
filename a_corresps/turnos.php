<?php
	require_once("db_.php");
	$id=$_REQUEST['id'];
	///////////////////////////////////////////////////////////////
	$sql="SELECT * FROM yoficioszep
	left outer join personal on personal.idpersona=yoficioszep.idpersturna
	where idoficio='$id' order by idoficiop asc limit 1";
	$row0 = $db->general($sql);

	echo "<table class='table table-hover table-sm' >";

	$hijos=0;
	$sql="SELECT * FROM yoficioszep left outer join personal on personal.idpersona=yoficioszep.idpersturna where idofp='".$row0[0]['idoficiop']."'";
	$nivel1 = $db->general($sql);
	if (count($nivel1)>0){
		$hijos=1;
		$arreglo=array();
		$arreglo=array('contesto'=>1);
		$db->update('yoficioszep',array('idoficiop'=>$row0['0']['idoficiop']), $arreglo);
	}
	echo "<tr>";
	echo "<td colspan=10>";
	echo "<div class='btn-group'>";
		echo  "<a title='Detalle' id='detalle' class='";
		echo "btn btn-outline-dark btn-sm";
		echo "' data-fechturnado='".$row0[0]['fechturnado']."'";
		echo "' data-fleido='".$row0[0]['fleido']."'";
		echo ">";
		if ($row0[0]['contesto']==1) echo "<i class='fa fa-check'></i>";
		else echo "<i class='fa fa-info'></i>";
		echo "</a>";

	echo "</div>";

	echo "<b>".$row0[0]['nombre']."</b></font>";
	echo "</td>";

	echo "</tr>";

	if (count($nivel1)>0){
		turnados_salida($nivel1,0,$id);
	}
	else{

	}

	echo "</table>";


	function turnados_salida($nivel1,$nivel,$id){
		global $db;
		$nivel++;
		if (count($nivel1)>0){
			for($i=0;$i<count($nivel1);$i++){

				$sql="SELECT * FROM yoficioszep left outer join personal on personal.idpersona=yoficioszep.idpersturna where idofp='".$nivel1[$i]['idoficiop']."'";
				$nivel2 = $db->general($sql);
				$hijos=0;

				if (count($nivel2)>0){
					$hijos=1;
					//echo "tiene hijo".$nivel1[$i]['idoficiop'];
				}

				echo "<tr>";
				for ($z=0;$z<$nivel;$z++){
					echo "<td width='30px'>-</td>";
				}
				$colx=10-$nivel;
				echo "<td colspan=$colx>";
					echo "<div class='btn-group'>";
						echo  "<a id='detalle' title='Detalle' class='";
						if ($nivel1[$i]['contesto']==1) echo "btn btn-outline-dark btn-sm btn-sm";
						else echo "btn btn-warning btn-sm";
						echo "' data-fechturnado='".$nivel1[$i]['fechturnado']."'";
						echo "' data-fleido='".$nivel1[$i]['fleido']."'";
						echo ">";
						if ($nivel1[$i]['contesto']==1) echo "<i class='fa fa-check'></i>";
						else echo "<i class='fa fa-info'></i>";
						echo "</a> ";

						$sql="select * from yoficioszep where idoficiop='".$nivel1[$i]['idofp']."'";
						$rxp = $db->general($sql);

						if($hijos==0 and (($nivel1[$i]['contesto']==0 and ( $rxp[0]['idpersturna']==$_SESSION['idpersona'] or ($rxp[0]['idpersturna']==$_SESSION['superior'] and $db->nivel_personal==7))) or $db->nivel_personal==0))   {		////////////////////eliminar turno
							echo  "<a id='eliminar_turnosal' title='Eliminar turno' class='btn btn-outline-dark btn-sm btn-sm'
							data-lugar='a_corresps/db_'
							data-destino='a_corresps/turnos'
							data-id='".$nivel1[$i]['idoficiop']."'
							data-funcion='borraturno'
							data-div='turnos'
							data-iddest='$id'
							><i class='far fa-trash-alt'></i></a>";
						}
					echo "</div>";

				echo "<b>".$nivel1[$i]['nombre']."</b></font>";
				echo "</td>";
				echo "<td>";
				echo "</td>";
				if (count($nivel2)>0){
					turnados_salida($nivel2,$nivel,$id);
				}
				echo "</tr>";
			}
		}
	}
?>
