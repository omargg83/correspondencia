<?php
require_once("db_.php");

$val="";
$filtro="";
$titulo="";
$nombre="";
$valor="";
if (isset($_REQUEST['funcion'])){
	$nombre=$_REQUEST['funcion'];
}

if($nombre=="avanzada"){			////busqueda avanzada
	$titulo="Busqueda avanzada";

	$arreglo=array();
	if (strlen($_REQUEST['desde']) and  strlen($_REQUEST['hasta'])){
		$de=explode("-",$_REQUEST['desde']);
		$desde=$de['2']."-".$de['1']."-".$de['0']." 00:00:00";

		$ha=explode("-",$_REQUEST['hasta']);
		$hasta=$ha['2']."-".$ha['1']."-".$ha['0']." 23:59:59";
		array_push($arreglo,"fechaofi between '$desde' and '$hasta'");
	}
	if (strlen($_REQUEST['interno'])>0){
		array_push($arreglo,"numero like '%".$_REQUEST['interno']."%'");
	}
	if (strlen($_REQUEST['numero'])>0){
		array_push($arreglo,"numoficio like '%".$_REQUEST['numero']."%'");
	}
	if (strlen($_REQUEST['asunto'])>0){
		array_push($arreglo,"asunto like '%".$_REQUEST['asunto']."%'");
	}
	if (strlen($_REQUEST['remitente'])>0){
		array_push($arreglo,"remitente like '%".$_REQUEST['remitente']."%'");
	}
	if (strlen($_REQUEST['cargo'])>0){
		array_push($arreglo,"cargo like '%".$_REQUEST['cargo']."%'");
	}
	if (strlen($_REQUEST['dependencia'])>0){
		array_push($arreglo,"dependencia like '%".$_REQUEST['dependencia']."%'");
	}
	if (strlen($_REQUEST['contestado'])>0){
		array_push($arreglo,"contestado='".$_REQUEST['contestado']."'");
	}
	for($i=0;$i<count($arreglo);$i++){
		if($i>0){
			$filtro.=" and ";
		}
		$filtro.=$arreglo[$i];
	}

	if($db->nivel_personal==0){
		$sql="select * from yoficios LEFT OUTER JOIN yoficiosp on yoficiosp.idoficio=yoficios.idoficio where $filtro GROUP BY yoficios.IDOFICIO order by yoficios.IDOFICIO desc limit 100";
	}
	else if($db->nivel_personal==7 or $db->nivel_personal==12){
		$sql="select * from yoficios
		LEFT OUTER JOIN yoficiosp on yoficiosp.idoficio=yoficios.idoficio where (yoficiosp.idpersturna='".$_SESSION['superior']."' or yoficiosp.idpersturna='".$_SESSION['idpersona']."') and $filtro GROUP BY yoficios.IDOFICIO order by yoficios.IDOFICIO desc limit 100";
	}
	else{
		$sql="select * from yoficios
		LEFT OUTER JOIN yoficiosp on yoficiosp.idoficio=yoficios.idoficio where yoficiosp.idpersturna='".$_SESSION['idpersona']."' and $filtro GROUP BY yoficios.IDOFICIO order by yoficios.IDOFICIO desc limit 100";
	}
	$c_listado = $db->general($sql);
}
if($nombre=="lista_area" or $nombre==""){			/////////////mis oficios pendientes
	$titulo="<i class='far fa-folder-open'></i> Mis Oficios pendientes";
	$c_listado = json_decode($db->c_listado(),true);
}
if($nombre=="ctodos"){				////todos los oficios del año
	$titulo="<i class='far fa-calendar-alt'></i> Todos los oficios del: ".$_SESSION['anio'];
	$c_listado = $db->c_todos();
}
if($nombre=="buscar"){
	$fecha=date("d-m-Y");

	$nuevafecha = strtotime ( '-3 month' , strtotime ( $fecha ) ) ;
	$fecha1 = date ( "d-m-Y" , $nuevafecha );
	//////////////////////////////////////////////////////////////////////////////////////
	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
		echo "<form id='consulta_avanzada' action='' data-destino='a_corresp/lista' data-div='resultado' data-funcion='avanzada' autocomplete='off'>";
			echo "<div class='row'>";
				echo "<div class='col-sm-2'>";
					echo "<label>Desde:</label>";
					echo "<input class='form-control' placeholder='Desde....' type='text' id='desde' name='desde' value='$fecha1'>";
				echo "</div>";

				echo "<div class='col-sm-2'>";
					echo "<label>Hasta:</label>";
					echo "<input class='form-control' placeholder='Hasta....' type='text' id='hasta' name='hasta' value='$fecha'>";
				echo "</div>";

				echo "<div class='col-sm-2'>";
					echo "<label># Interno</label>";
					echo "<input class='form-control' placeholder='# interno' type='text' id='interno' name='interno' value=''>";
				echo "</div>";

				echo "<div class='col-sm-2'>";
					echo "<label>Número Oficio</label>";
					echo "<input class='form-control' placeholder='Numero de oficio' type='text' id='numero' name='numero' value=''>";
				echo "</div>";

				echo "<div class='col-sm-4'>";
					echo "<label>Asunto</label>";
					echo "<input class='form-control' placeholder='Asunto' type='text' id='asunto' name='asunto' value=''>";
				echo "</div>";

				echo "<div class='col-sm-3'>";
					echo "<label>Remitente</label>";
					echo "<input class='form-control' placeholder='Remitente' type='text' id='remitente' name='remitente' value=''>";
				echo "</div>";

				echo "<div class='col-sm-3'>";
					echo "<label>Cargo</label>";
					echo "<input class='form-control' placeholder='Cargo' type='text' id='cargo' name='cargo' value=''>";
				echo "</div>";

				echo "<div class='col-sm-3'>";
					echo "<label>Dependencia</label>";
					echo "<input class='form-control' placeholder='Dependencia' type='text' id='dependencia' name='dependencia' value=''>";
				echo "</div>";

				echo "<div class='col-sm-2'>";
					echo "<label>Tipo de documento</label>";
					echo "<select id='contestado' name='contestado' class='form-control'>";
						echo "<option value=''></option>";
						echo "<option value='0'>Pendiente</option>";
						echo "<option value='1'>Contestado</option>";
					echo "</select>";
				echo "</div>";

			echo "</div><br>";
			echo "<div class='row'>";
				echo "<div class='col-sm-4'>";
					echo "<div class='btn-group'>";
					echo "<button class='btn btn-outline-secondary btn-sm' type='submit' id='acceso'><i class='fas fa-search'></i>Buscar</button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "*Solo se muestran los primeros 100 registros de la busqueda";
		echo "</form>";
	echo "</div>";
	//////////////////////////////////////////////////////////////////////////////////////


	$valor=$_REQUEST['valor'];
	if(strlen($valor)>=2){
		$titulo="<i class='fab fa-searchengin'></i> Resultado de la busqueda en mis oficios turnados de: <b>$valor</b> <br><span style='font-size:10px;'>*Solo se consultan los primeros 300 registros</span>";
		$c_listado = $db->c_buscar($valor);
	}
	else{
		echo "";
		die();
	}
}				///Busqueda normal
if($nombre=="entrada"){				///firma de entregado
	$titulo="Firma de entregado";
	if (isset($_REQUEST['idpersona_firma']) and strlen($_REQUEST['idpersona_firma'])>0){
		$idpersona=$_REQUEST['idpersona_firma'];
		$filtro=" and yoficiosp.idpersturna='$idpersona'";
	}
	if($db->nivel_personal==7 or $db->nivel_personal==12){
		$sql="select yoficiosp.*, ofalias.idpersturna as de, yoficios.clasificacion, yoficios.numoficio, yoficios.fechaofi, yoficios.contestado, yoficios.numero, yoficios.remitente, yoficios.asunto, yoficios.texto, yoficios.anexos, yoficios.urgente, yoficios.atencion, yoficios.conocimiento, yoficios.acuerdo, yoficios.oficio, yoficios.archivar from yoficiosp
		left outer join yoficiosp ofalias on ofalias.idoficiop=yoficiosp.idofp
		left outer join yoficios on yoficios.idoficio=yoficiosp.idoficio
		where (ofalias.idpersturna='".$_SESSION['idpersona']."' or ofalias.idpersturna='".$_SESSION['superior']."') $filtro and yoficiosp.estado=0
		order by yoficiosp.idoficiop asc";
	}
	else{
		$sql="select yoficiosp.*, ofalias.idpersturna as de, yoficios.clasificacion, yoficios.numoficio, yoficios.fechaofi, yoficios.contestado, yoficios.numero, yoficios.remitente, yoficios.asunto, yoficios.texto, yoficios.anexos, yoficios.urgente, yoficios.atencion, yoficios.conocimiento, yoficios.acuerdo, yoficios.oficio, yoficios.archivar from yoficiosp
		left outer join yoficiosp ofalias on ofalias.idoficiop=yoficiosp.idofp
		left outer join yoficios on yoficios.idoficio=yoficiosp.idoficio
		where (ofalias.idpersturna='".$_SESSION['idpersona']."') $filtro and yoficiosp.estado=0
		order by yoficiosp.idoficiop asc";
	}
	$c_listado = $db->general($sql);
}
if($nombre=="recepcion"){			////pendientes de firma
	$titulo="<i class='fas fa-signature'></i> Oficios pendientes por firmar de recibido";
	if($db->nivel_personal==7){
		$sql="select * FROM yoficios yof LEFT OUTER JOIN yoficiosp on yoficiosp.idoficio=yof.idoficio
		where (yoficiosp.idpersturna='".$_SESSION['idpersona']."' or yoficiosp.idpersturna='".$_SESSION['superior']."') and yoficiosp.contesto=0 and yof.contestado=0 and yoficiosp.estado=0 order by yoficios.idoficio desc";
	}
	else{
		$sql="select * FROM yoficios yof LEFT OUTER JOIN yoficiosp on yoficiosp.idoficio=yof.idoficio
		where yoficiosp.idpersturna='".$_SESSION['idpersona']."' and yoficiosp.contesto=0 and yof.contestado=0 and yoficiosp.estado=0 order by yoficios.idoficio desc";
	}
	$c_listado = $db->general($sql);
}
if($nombre=="libro"){					///libro
	$titulo="Libro";
	$hasta=date("Y-m-d");
	$nuevafecha = strtotime ( '-5 day' , strtotime ( $hasta ) ) ;
	$desde = date ( "Y-m-d" , $nuevafecha )." 00:00:00";
	$hasta.=" 23:59:59";
	if(isset($_REQUEST['desde'])){
		$de=explode("-",$_REQUEST['desde']);
		$desde=$de['2']."-".$de['1']."-".$de['0']." 00:00:00";
	}
	if(isset($_REQUEST['hasta'])){
		$ha=explode("-",$_REQUEST['hasta']);
		$hasta=$ha['2']."-".$ha['1']."-".$ha['0']." 23:59:59";
	}

	if($db->nivel_personal==7 or $db->nivel_personal==12){
		$sql="select yoficiosp.*, ofalias.idpersturna as de, yoficios.clasificacion, yoficios.numoficio, yoficios.fechaofi, yoficios.contestado, yoficios.numero, yoficios.remitente, yoficios.asunto, yoficios.texto, yoficios.anexos, yoficios.urgente, yoficios.atencion, yoficios.conocimiento, yoficios.acuerdo, yoficios.oficio, yoficios.archivar from yoficiosp
		left outer join yoficiosp ofalias on ofalias.idoficiop=yoficiosp.idofp
		left outer join yoficios on yoficios.idoficio=yoficiosp.idoficio
		where (ofalias.idpersturna='".$_SESSION['idpersona']."' or ofalias.idpersturna='".$_SESSION['superior']."') and yoficiosp.estado=1 and yoficiosp.frecibido between '$desde' and '$hasta'
		order by yoficiosp.idoficiop asc ";
	}
	else{
		$sql="select yoficiosp.*, ofalias.idpersturna as de, yoficios.clasificacion, yoficios.numoficio, yoficios.fechaofi, yoficios.contestado, yoficios.numero, yoficios.remitente, yoficios.asunto, yoficios.texto, yoficios.anexos, yoficios.urgente, yoficios.atencion, yoficios.conocimiento, yoficios.acuerdo, yoficios.oficio, yoficios.archivar from yoficiosp
		left outer join yoficiosp ofalias on ofalias.idoficiop=yoficiosp.idofp
		left outer join yoficios on yoficios.idoficio=yoficiosp.idoficio
		where (ofalias.idpersturna='".$_SESSION['idpersona']."') and yoficiosp.estado=1 and yoficiosp.frecibido between '$desde' and '$hasta'
		order by yoficiosp.idoficiop asc ";
	}
	$c_listado = $db->general($sql);
}

$contaor=1;
echo "<form>";
echo "<div class='container-fluid'>";

if($nombre=="lista_area" or $nombre==""){				////////////////////Oficios Pendientes+
		$anio=$_SESSION['anio']-2;
		if($db->nivel_personal==7){
			$sql="select * FROM yoficios yof LEFT OUTER JOIN yoficiosp on yoficiosp.idoficio=yof.idoficio
			where yof.year>='$anio' and (yoficiosp.idpersturna='".$_SESSION['idpersona']."' or yoficiosp.idpersturna='".$_SESSION['superior']."') and yoficiosp.contesto=0 and yoficiosp.estado=0 order by yof.idoficio desc";
		}
		else{
			$sql="select * FROM yoficios yof LEFT OUTER JOIN yoficiosp on yoficiosp.idoficio=yof.idoficio
			where yof.year>='$anio' and yoficiosp.idpersturna='".$_SESSION['idpersona']."' and yoficiosp.contesto=0 and yoficiosp.estado=0 order by yof.idoficio desc";
		}
		$recibir = $db->general($sql);
		echo "<div class='row'>";
			echo "<div class='col-6' style='background-color:white;opacity:.7'>
			  <i class='fas fa-signature'></i><b>Pendientes por firmar de recibido</b>";
			echo "</div>";
		echo "</div>";
		tabla($recibir,1,"recepcion");
}

echo "<div class='row'>";
	echo "<div class='col-6' style='background-color:white;opacity:.7'>
		<b>$titulo</b>
	</div>";
echo "</div>";
tabla($c_listado,1,$nombre);

if($nombre=="lista_area" or $nombre==""){
	if($db->nivel_personal==7 or $db->nivel_personal==0){
		$superior=$db->personal_edit($_SESSION['superior']);
		echo "<div class='row'>";
			echo "<div class='col-6' style='background-color:white;opacity:.7'>
			  <i class='fas fa-signature'></i><b>Pendientes de: ".$superior['nombre']."</b>
			</div>";
		echo "</div>";
		$recibir = json_decode($db->c_superiorlista(),true);
		tabla($recibir,1,$nombre);
	}
}

if($nombre=="buscar"){				//////busqueda global
	echo "<div class='row'>";
		echo "<div class='col-12' style='background-color:white;opacity:.7'>";
			echo "<br><h5><i class='fas fa-user-check'></i>Busqueda en todo el sistema $valor</h5><hr>";
			echo "NUEVO</br>";
			echo "-Esta nueva opción busca en todo el sistema con opciones limitadas.<br>";
			echo "-La busqueda incluye todos los oficios aunque no esten turnados.<br>";
			echo "-Se deberá de solicitar el acceso total al oficio.<br>";
			echo "-La autorización del oficio se hace en cuestion de minutos por el administrador del sistema<hr>";
			$recibir = $db->buscar_todo($valor);
			tabla($recibir,1,"buscar2");
		echo "</div>";
	echo "</div>";
}
echo "<br>";
echo "</form>";


function tabla($row,$tipo,$nombre){
	global $db;
	echo "<div class='row' style='background-color:white;opacity:.9;font-size:12px'>";
		echo  "<div class='col-2'><b></b></div>";
		echo  "<div class='col-1'><b>INTERNO</b></div>";
		echo  "<div class='col-2'><b>NUM.</b></div>";
		echo  "<div class='col-5'><b>OFICIO</b></div>";
		echo  "<div class='col-2'><b>RECIBIO</b></div>";
		$prim=0;
	echo "</div>";

			$bcolor="";
			foreach($row as $key){
				if (strlen(trim($key['asunto']))==0 or strlen(trim($key['remitente']))==0){
					$bgolor="#dad0d2";
				}
				else{
					$bgolor="white";
				}
				echo "<div class='row' style='border-bottom:.5px solid #cccbca;background-color:$bgolor;opacity:.9;font-size:13px;' >";
					echo  "<div class='col-2 edit-t' id=".$key['idoficio']." >";
						echo  "<div class='btn-group'>";
						if($nombre=="entrada" or $nombre=="recepcion"){
							echo  "<div class='input-group-text'><input type='checkbox' value='".$key['idoficio']."' id='ck_of_".$key['idoficio']."' name='ck_of_".$key['idoficio']."' checked style=''></div>";
							if($nombre=="recepcion")
							echo  "<button type='button' class='btn btn-outline-secondary pull-left btn-sm' id='unicafirma' title='Firma' onclick='firma_unica(".$key['idoficio'].",".$key['numero'].")'><i class='fas fa-signature'></i>Firma</button>";
						}
							if ($nombre=="" or $nombre=="libro" or $nombre=="ctodos" or $nombre=="buscar"){
								echo  "<button class='btn btn-outline-secondary pull-left btn-sm' id='edit_corresp".$key['idoficio']."' title='Editar' data-lugar='a_corresp/editar'><i class='fas fa-pencil-alt'></i></button>";
								$tipo=2;
							}
							else{
								$tipo=3;
							}
							echo  "<button class='btn btn-outline-secondary pull-left btn-sm' id='winmodal_pass".$key['idoficio']."' title='Editar'  data-id='".$key['idoficio']."' data-id2='$tipo' data-lugar='a_corresp/editar' ><i class='far fa-eye'></i></button>";
						echo  "</div>";
					echo  "</div>";

					echo  "<div class='col-1' style='overflow:hidden; white-space:nowrap;text-overflow: ellipsis;'>";
					echo  "<b># ".$key['numero']."</b><br>";
					echo  "</div>";

					echo  "<div class='col-2' style='overflow:hidden; white-space:nowrap;text-overflow: ellipsis;'><b>".$key['numoficio']."</b>";
					echo  "<br>(".fecha($key['fechaofi']).")<br>";
					if (strlen(trim($key['asunto']))==0 or strlen(trim($key['remitente']))==0){
						echo "<b><i class='fas fa-bell'></i>FALTA INFORMACION</b>";
					}
					echo "</div>";

					echo  "<div class='col-5' style='overflow:hidden; white-space:nowrap;text-overflow: ellipsis;'>";
					echo  "<b>".$key['remitente']."</b>";
					echo  $key['texto'];
					echo  $key['asunto'];

					if(strlen($key['anexos'])>0){
						echo "<br><i class='fas fa-paperclip' style='color:black'></i>".$key['anexos'];
					}
					echo "<br>";
					if($key['urgente']==1){ echo "<span class='badge badge-secondary' style='background-color:silver'><i class='fas fa-radiation-alt fa-lg' title='URGENTE' style='color:red'></i>URGENTE</span>"; }
					if($key['atencion']==1){ echo "<span class='badge badge-secondary' style='background-color:silver'><i class='fas fa-exclamation-circle' title='Atención' style='color:yellow'></i>ATENCIÓN</span>"; }
					if($key['conocimiento']==1){  echo "<span class='badge badge-secondary' style='background-color:silver'><i class='far fa-eye' title='Para su conocimiento' style='color:green'></i>CONOCIMIENTO</span>"; }
					if($key['acuerdo']==1){  echo "<span class='badge badge-secondary' style='background-color:silver'><i class='fas fa-users' title='Para acuerdo' style='color:black'></i>ACUERDO</span>"; }
					if($key['oficio']==1){  echo "<span class='badge badge-secondary' style='background-color:silver'><i class='far fa-copy' title='Contestar con oficio' style='color:blue'></i>OFICIO</span>"; }
					if($key['archivar']==1){  echo "<span class='badge badge-secondary' style='background-color:silver'><i class='far fa-folder-open' title='Archivar' style='color:#8e8e9a'></i>ARCHIVAR</span>"; }
					echo  "</div>";

					echo  "<div class='col-2'>";
					if(strlen($key['idrecibido'])>0){
						echo  "<span style='font-size:10px;'>";
						$recibix=$db->personal_edit($key['idrecibido']);
						echo  $recibix['nombre'];
						echo  "<br>".fecha($key['frecibido'],2)."";
						echo  "</span>";
					}
					else{
						echo  "FALTA FIRMA";
					}
					echo  "</div>";
				echo "</div>";

			}
		if($nombre=="entrada" or $nombre=="recepcion"){
			echo "<div class='row' style='border:1px solid silver;background-color:white;opacity:.8;font-size:12px'>";
				echo "<div class='col-2'>";
				echo "<button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal' onclick='firmar_cor(\"$nombre\")' data-tipof='recepcion'><i class='fas fa-signature'></i> Firmar</button>";
				echo "</div>";
			echo "</div>";
		}
		echo "<br>";
}
?>

<script type="text/javascript">
	clearInterval(vscan);
	vscan="";
</script>
