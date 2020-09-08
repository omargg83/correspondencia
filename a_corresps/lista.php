<?php
	require_once("db_.php");

	$val="";
	$filtro=0;
/*
	if($db->nivel_personal==0){
		$fecha=date("Y-m-d");
		$nuevafecha = strtotime ( '-3 month' , strtotime ( $fecha ) ) ;
		$fecha1 = date ( "Y-m-d" , $nuevafecha );
		$sql="select idoficio from yoficiosze where fecha<='$fecha1' and contestado=0";
		$marcados = $db->general($sql);
		foreach ($marcados as $key => $value) {
			$arreglo=array();
			$arreglo=array('contestado'=>1);
			$db->update('yoficiosze',array('idoficio'=>$value['idoficio']), $arreglo);

			$arreglo=array();
			$arreglo=array('contesto'=>1);
			$db->update('yoficioszep',array('idoficio'=>$value['idoficio']), $arreglo);
		}
	}
*/
	$nombre="";
	if (isset($_REQUEST['funcion'])){
		$nombre=$_REQUEST['funcion'];
	}

	if($nombre=="area" or $nombre==""){
		$titulo="Oficios pendientes";
		$c_listado = $db->c_listado();
	}
	if($nombre=="ctodos"){
		$titulo="Todos los oficios de salida";
		$c_listado = $db->c_todos();
	}
	if($nombre=="buscar"){
		$valor=$_REQUEST['valor'];
		if(strlen($valor)>1){
			$titulo="Resultado de la busqueda de: <b>$valor</b> ";
			$c_listado = $db->c_buscar($valor);
		}
		else{
			echo "";
			die();
		}
	}
	if($nombre=="avanzada"){
		$titulo="Busqueda avanzada";
		$arreglo=array();

		if (strlen($_REQUEST['desde']) and  strlen($_REQUEST['hasta'])){
			$de=explode("-",$_REQUEST['desde']);
			$desde=$de['2']."-".$de['1']."-".$de['0']." 00:00:00";

			$ha=explode("-",$_REQUEST['hasta']);
			$hasta=$ha['2']."-".$ha['1']."-".$ha['0']." 23:59:59";
			array_push($arreglo,"yoficiosze.fecha between '$desde' and '$hasta'");
		}
		if (strlen($_REQUEST['numero'])>0){
			array_push($arreglo,"yoficiosze.numero like '%".$_REQUEST['numero']."%'");
		}
		if (strlen($_REQUEST['asunto'])>0){
			array_push($arreglo,"asunto like '%".$_REQUEST['asunto']."%'");
		}
		if (strlen($_REQUEST['remitente'])>0){
			array_push($arreglo,"destinatario like '%".$_REQUEST['remitente']."%'");
		}
		if (strlen($_REQUEST['cargo'])>0){
			array_push($arreglo,"cargo like '%".$_REQUEST['cargo']."%'");
		}
		if (strlen($_REQUEST['dependencia'])>0){
			array_push($arreglo,"dependencia like '%".$_REQUEST['dependencia']."%'");
		}
		if (strlen($_REQUEST['documento'])>0){
			array_push($arreglo,"documento like '%".$_REQUEST['documento']."%'");
		}

		$filtro="";
		for($i=0;$i<count($arreglo);$i++){
			if($i>0){
				$filtro.=" and ";
			}
			$filtro.=$arreglo[$i];
		}

		$texto="";
		if($db->nivel_personal==0){
			$sql="select yoficiosze.*,elabora.nombre as elabora from yoficiosze
				left outer join personal firma on firma.idpersona=yoficiosze.idfirma
				left outer join personal elabora on elabora.idpersona=yoficiosze.idelabora
				where $filtro and '".$_SESSION['idcentro']."' order by idoficio desc limit 300";
		}
		else{
			$sql="select yoficiosze.*,elabora.nombre as elabora from yoficiosze
				left outer join personal firma on firma.idpersona=yoficiosze.idfirma
				left outer join personal elabora on elabora.idpersona=yoficiosze.idelabora
				where $filtro and '".$_SESSION['idcentro']."' and (firma.idarea='".$_SESSION['idarea']."' or elabora.idarea='".$_SESSION['idarea']."') order by idoficio desc limit 300";
		}
		$c_listado = $db->general($sql);
	}
	if($nombre=="cancelados"){
		$titulo="Oficios cancelados del año: ".$_SESSION['anio'];
		$c_listado = $db->cancelados();
	}
	$contaor=1;
		echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";

			echo "<div class='dysplay content table-responsive table-full-width' >";
				echo "<h5>$titulo</h5><hr>";
				echo "<table id='x_lista' class='display compact hover' style='font-size:12pt;'>";

				echo "<thead><tr>";
				echo "<th >-</th>";
				echo "<th >#</th>";
				echo "<th >Tipo</th>";
				echo "<th width='100px'>Fecha</b></th>";
				echo "<th >Remitente</th>";
				echo "</tr>";
				echo "</thead><tbody>";
				$prim=0;
				foreach ($c_listado as $key ){
						$varx="";
						if ($key['documento']=='oficio') {
							$bgcolor='';
							$tipx="Oficio";
						}
						if ($key['documento']=='memo') {
							$bgcolor='';
							$tipx="Memorandum";
						}
						if ($key['documento']=='comision') {
							$bgcolor='';
							$tipx="Oficio de Comisión";
						}
						if ($key['documento']=='circular') {
							$bgcolor='';
							$tipx="Oficio circular";
						}

						echo "<tr id=".$key['idoficio']." class='edit-t $varx'>";
						echo "<td>";
						echo "<button class='btn btn-outline-secondary btn-sm' id='edit_corresp' title='Editar' data-lugar='a_corresps/editar'><i class='fas fa-pencil-alt'></i></button>";
						echo "</td>";

						echo "<td>";
						echo $key['numero'];
						echo "</td>";

						echo "<td bgcolor='$bgcolor'>";
						echo $tipx;
						echo "</td>";

						echo "<td>".fecha($key['fecha'])."</td>";
						echo "<td>";
						echo "<b>-".$key['destinatario']."</b><br>";
						echo "-(".$key['dependencia'].")<br>";
						echo $key['asunto'];
						echo "</td>";

						echo "</td>";

						echo "</tr>";
				}
				echo "</table><br>";

			echo "</div>";
		echo "</div><br>";

		if($nombre=="buscar"){
			echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
			echo "<br><h5><i class='fas fa-user-check'></i>Busqueda en todo el sistema $valor</h5><hr>";
			echo "NUEVO</br>";
			echo "-Esta nueva opción busca en todo el sistema con opciones limitadas.<br>";
			echo "-La busqueda incluye todos los oficios aunque no esten turnados.<br>";
			echo "-Se deberá de solicitar el acceso total al oficio.<br>";
			echo "-La autorización del oficio se hace en cuestion de minutos por el administrador del sistema<br>";
			///////////////////////////////////////////////////////////////////////////////////
			$recibir = $db->buscar_todo($valor);

				echo "<div class='dysplay content table-responsive table-full-width' >";
					echo "<h5>$titulo</h5><hr>";
					echo "<table id='x_lista' class='display compact hover' style='font-size:12pt;'>";

					echo "<thead><tr>";
					echo "<th >!</th>";
					echo "<th >-</th>";
					echo "<th >#</th>";
					echo "<th >Tipo</th>";
					echo "<th width='100px'>Fecha</b></th>";
					echo "<th >Remitente</th>";
					echo "</tr>";
					echo "</thead><tbody>";
					$prim=0;
					for($i=0;$i<count($recibir);$i++){
						$varx="";
						if ($recibir[$i]['documento']=='oficio') {
							$bgcolor='';
							$tipx="Oficio";
						}
						if ($recibir[$i]['documento']=='memo') {
							$bgcolor='';
							$tipx="Memorandum";
						}
						if ($recibir[$i]['documento']=='comision') {
							$bgcolor='';
							$tipx="Oficio de Comisión";
						}
						if ($recibir[$i]['documento']=='circular') {
							$bgcolor='';
							$tipx="Oficio circular";
						}

							echo "<tr id=".$recibir[$i]['idoficio']." class='edit-t $varx'>";
							echo "<td>";
							echo $i+1;
							echo "</td>";
							echo "<td>";
							echo "<button class='btn btn-outline-secondary btn-fill pull-left btn-sm' id='winmodal_pass' title='Editar'  data-id='".$recibir[$i]['idoficio']."' data-id2='2' data-lugar='a_corresps/editar' ><i class='far fa-eye'></i></button>";
							echo "</td>";

							echo "<td>";
							echo $recibir[$i]['numero'];
							echo "</td>";

							echo "<td bgcolor='$bgcolor'>";
							echo $tipx;
							echo "</td>";

							echo "<td>".fecha($recibir[$i]['fecha'])."</td>";
							echo "<td>";
							echo "<b>-".$recibir[$i]['destinatario']."</b><br>";
							echo $recibir[$i]['asunto'];
							echo "</td>";

							echo "</td>";

							echo "</tr>";
					}
					echo "</tbody>";
					echo "</table><br>";

				echo "</div>";
			echo "</div>";
		}

?>
<script>
$(document).ready( function () {
	$('table.display').DataTable({
		"pageLength": 100,
		"language": {
			"sSearch": "Buscar aqui",
			"lengthMenu": "Mostrar _MENU_ registros",
			"zeroRecords": "No se encontró",
			"info": " Página _PAGE_ de _PAGES_",
			"infoEmpty": "No records available",
			"infoFiltered": "(filtered from _MAX_ total records)",
			"paginate": {
				"first":      "Primero",
				"last":       "Ultimo",
				"next":       "Siguiente",
				"previous":   "Anterior"
			},
		}
	});
});

console.log("cancelar interval"+vscan);
clearInterval(vscan);
vscan="";
</script>
