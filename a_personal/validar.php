<?php
	require_once("db_.php");
	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
		echo "<form id='form_validar' action='' data-lugar='a_personal/db_' data-funcion='validar' data-destino='a_personal/personal' autocomplete='off'>";
		if ($db->nivel_personal==0 or $db->nivel_personal==11){
			$sql="select * from area where tipo<=3 order by area.orden";
		}
		if ($db->nivel_personal==1){
			$sql="select * from area where tipo<=3 order by area.orden";
		}
		if ($db->nivel_personal==2){
			$sql="select * from area where idarea='".$_SESSION['idarea']."' or sub='".$_SESSION['idarea']."'";
			$areas=$db->general($sql);
			$listaar="";
			for($i=0;$i<count($areas);$i++){
				$listaar.=$areas[$i]['idarea'].",";
			}
			$listaar=substr($listaar,0,strlen($listaar)-1);
			$sql="select * from area where idarea in($listaar) and tipo<=3 order by area.orden";
		}
		if ($db->nivel_personal==3 or $db->nivel_personal==10){
			$sql="select * from area where idarea='".$_SESSION['idarea']."' and tipo<=3 order by area.orden";
		}
		if ($db->nivel_personal==4){
			$sql = "select * from area where area.idcentro='".$_SESSION['idcentro']."' and tipo<=3 order by area.orden";
		}
		$pd = $db->general($sql);

		echo "<table class='table'><tr><th><b>Seleccione las areas a validar:</b><br></th></tr>";
		echo "<tr><td><select class='form-control' id='idareap[]' name='idareap[]' multiple style='width:600px' size='20' >";
		for($i=0;$i<count($pd);$i++){
			echo "<option value='".$pd[$i]['idarea']."'";
			if($pd[$i]['idarea']==$_SESSION['idarea']){ echo " selected";}
			echo ">".$pd[$i]['area']."</option>";
		}
		echo "</select>";
		echo "</td>";
		echo "<td>";
		echo "<button class='btn btn-outline-secondary btn-sm' type='submit' id='acceso'><i class='fas fa-check-double'></i>Validar</button>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
	echo "</div>";
?>
