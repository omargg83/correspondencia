<?php
	require_once("db_.php");

	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
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

		echo "<table class='table'><tr><th><b>Seleccione las areas a imprimir:</b><br></th></tr>";
		echo "<tr><td><select class='form-control' id='idareap' name='idareap' multiple style='width:600px' size='20' >";
		for($i=0;$i<count($pd);$i++){
			echo "<option value='".$pd[$i]['idarea']."'";
			if($pd[$i]['idarea']==$_SESSION['idarea']){ echo " selected";}
			echo ">".$pd[$i]['area']."</option>";
		}
		echo "</select>";
		echo "</td>";
		echo "<td>";
		echo "<button class='btn btn-outline-secondary btn-sm' id='imprime_personal' title='Imprimir' data-lugar='a_personal/imprimir' data-tipo='1' type='button'  data-valor='idareap'><i class='fas fa-print'></i>Imprimir</button>";
		echo "</td>";
		echo "</tr>";

	echo "</div>";

?>
