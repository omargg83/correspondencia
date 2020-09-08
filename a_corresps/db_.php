<?php
require_once("../control_db.php");

if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

class Salida extends Salud{
	public $nivel_personal;
	public $nivel_captura;
	public $data;
	public function __construct(){
		parent::__construct();

		$sql="SELECT nivel,captura FROM personal_permiso where idpersona='".$_SESSION['idpersona']."' and nombre='CORRESPONDENCIA'";
		$stmt= $this->dbh->query($sql);
		$cuenta = $stmt->rowCount();
		if($cuenta>0){
			$row =$stmt->fetchObject();
			$this->nivel_personal=$row->nivel;
			$this->nivel_captura=$row->captura;
		}
		else{
			$this->nivel_captura=0;
			$this->nivel_personal=9;
		}
		$this->doc="a_archivos/a_corresp/";
	}
	public function c_entrada(){		////////////////////COMBO DE OFICIOS
		try{
			parent::set_names();
			$fecha=date("Y-m-d");
			$nuevafecha = strtotime ( '-2 month' , strtotime ( $fecha ) ) ;
			$fecha1 = date ( "Y-m-d" , $nuevafecha );

			if($this->nivel_personal==7 OR $this->nivel_personal==0 OR $this->nivel_personal==12){
				$sql="SELECT * from yoficioszep LEFT OUTER JOIN yoficiosze on yoficioszep.idoficio=yoficiosze.idoficio
				where (yoficiosze.contestado = 0 OR (yoficiosze.fecha > '$fecha1')) and
				(yoficioszep.idpersturna='".$_SESSION['superior']."' or yoficioszep.idpersturna='".$_SESSION['idpersona']."')
				order by yoficiosze.idoficio desc";
			}
			else{
				$sql="SELECT * from yoficioszep LEFT OUTER JOIN yoficiosze on yoficioszep.idoficio=yoficiosze.idoficio
				where (yoficiosze.contestado = 0 OR (yoficiosze.fecha > '$fecha1')) and
				yoficioszep.idpersturna='".$_SESSION['idpersona']."'
			 order by yoficiosze.idoficio desc";
			}
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function c_listado(){		////////////////////LISTADO DE OFICIOS
		try{
			parent::set_names();
			if($this->nivel_personal==7){
				$sql="SELECT * from yoficioszep LEFT OUTER JOIN yoficiosze on yoficioszep.idoficio=yoficiosze.idoficio where yoficioszep.contesto=0 and (yoficioszep.idpersturna='".$_SESSION['superior']."' or yoficioszep.idpersturna='".$_SESSION['idpersona']."') GROUP BY yoficiosze.IDOFICIO order by yoficiosze.idoficio desc";
			}
			else{
				$sql="SELECT * from yoficioszep LEFT OUTER JOIN yoficiosze on yoficioszep.idoficio=yoficiosze.idoficio where yoficioszep.contesto=0 and yoficioszep.idpersturna='".$_SESSION['idpersona']."' GROUP BY yoficiosze.IDOFICIO order by yoficiosze.idoficio desc";
			}
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function corregir($id){
		try{
			parent::set_names();
			$sql="SELECT * FROM yoficiosze where idoficio='$id'";
			$of = $this->dbh->prepare($sql);
			$of->execute();
			$row =$of->fetchObject();
			if($row->documento=="comision"){
				$arreglo=array();
				$arreglo=array('contestado'=>1);
				$this->update('yoficiosze',array('idoficio'=>$id), $arreglo);

				$arreglo=array();
				$arreglo=array('contesto'=>1);
				$this->update('yoficioszep',array('idoficio'=>$id), $arreglo);
			}
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function c_todos(){
		try{
			parent::set_names();
			$sql="SELECT yoficiosze.*,personal.idarea,personal.nombre as elabora FROM yoficiosze
			left outer join personal on personal.idpersona=yoficiosze.idelabora where idarea='".$_SESSION['idarea']."' order by yoficiosze.idoficio desc";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function cancelados(){
		try{
			parent::set_names();
			$sql="SELECT * from yoficiosze LEFT OUTER JOIN yoficioszep on yoficioszep.idoficio=yoficiosze.idoficio
			where yoficiosze.cancelado=1 and anio='".$_SESSION['anio']."' and (yoficioszep.idpersturna='".$_SESSION['superior']."' or yoficioszep.idpersturna='".$_SESSION['idpersona']."')
			GROUP BY yoficiosze.IDOFICIO order by yoficiosze.idoficio desc";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function c_buscar($texto){
		try{
			parent::set_names();
			$arreglo=array();
			$arreglo+=array('idpersona'=>$_SESSION['idpersona']);
			$arreglo+=array('fecha'=>date("Y-m-d H:i:s"));
			$arreglo+=array('monitor'=>"Buscar $texto");
			$arreglo+=array('modulo'=>"Correspondencia salida");
			$this->insert('acceso', $arreglo);

			if($this->nivel_personal==0){
				$sql="SELECT * FROM yoficiosze where (destinatario LIKE '%$texto%' or asunto LIKE '%$texto%' or dependencia LIKE '%$texto%' or numero LIKE '%$texto%') order by yoficiosze.idoficio desc limit 300";
			}
			else if($this->nivel_personal==7){
				$sql="SELECT * FROM yoficiosze left outer join yoficioszep on yoficioszep.idoficio=yoficiosze.idoficio WHERE
				(destinatario LIKE '%$texto%' or dependencia LIKE '%$texto%' or asunto LIKE '%$texto%' or numero LIKE '%$texto%')
				and ( yoficioszep.idpersturna = ".$_SESSION['idpersona']." or yoficioszep.idpersturna = ".$_SESSION['superior'].") GROUP BY yoficiosze.IDOFICIO order by yoficiosze.idoficio desc limit 300";
			}
			else{
				$sql="SELECT * FROM yoficiosze left outer join yoficioszep on yoficioszep.idoficio=yoficiosze.idoficio WHERE
				(destinatario LIKE '%$texto%' or dependencia LIKE '%$texto%' or asunto LIKE '%$texto%' or numero LIKE '%$texto%')
				and (yoficioszep.idpersturna = ".$_SESSION['idpersona'].") GROUP BY yoficiosze.IDOFICIO order by yoficiosze.idoficio desc limit 300";
			}
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED! $sql".$e->getMessage();
		}
	}
	public function buscar_todo($oficio){
		try{
			parent::set_names();
			$anio=$_SESSION['anio']-2;
			$sql="SELECT * FROM yoficiosze where anio>=$anio and ((destinatario LIKE '%$oficio%') or (asunto LIKE '%$oficio%') or (numero LIKE '%$oficio%')) order by idoficio desc limit 80";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}

	public function c_oficio($id){
		try{
			parent::set_names();
			$this->oficioe=array();
			$sql="SELECT * FROM yoficiosze where idoficio='$id'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetch();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function numero($table,$id){
		try{
			parent::set_names();
			$sql = "SELECT MAX($id) FROM $table where anio='".$_SESSION['anio']."' and idcentro='".$_SESSION['idcentro']."'";
			$statement = $this->dbh->prepare($sql);
			$statement->execute();
			$item_id = $statement->fetchColumn();
			return $item_id+1;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function c_archivos($id){
		try{
			parent::set_names();
			$sql="SELECT * FROM yoficiosze_archivos where idoficio='$id'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function c_acuse($id){
		try{
			parent::set_names();
			$sql="SELECT * FROM yoficiosze_archivosresp where idoficio='$id'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function c_recepcion($id){
		try{
			parent::set_names();
			$sql="select * from yoficiosze_recibir where idoficio='$id'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function centro_c(){
		try{
			parent::set_names();
			$this->accesox="";
			$sql="SELECT * FROM cord_che_centro_costos where idcentro='".$_SESSION['idcentro']."'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetch();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function correspondencia(){
		try{
			parent::set_names();
			$this->accesox=array();
			$sql="SELECT * FROM yoficiosze where entrega=1 order by idoficio desc";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}

	public function guardar(){
		$x="";
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		$arreglo =array();

		if (isset($_REQUEST['numero'])){
			$arreglo+=array('numero'=>$_REQUEST['numero']);
		}
		if (isset($_REQUEST['fecha'])){
			$fx=explode("-",$_REQUEST['fecha']);
			$arreglo+=array('fecha'=>$fx['2']."-".$fx['1']."-".$fx['0']);
		}
		if (isset($_REQUEST['documento'])){
			$documento=$_REQUEST['documento'];
			$arreglo+=array('documento'=>$documento);
		}

		if (isset($_REQUEST['destinatario_salida'])){
			$arreglo+=array('destinatario'=>$_REQUEST['destinatario_salida']);
		}
		if (isset($_REQUEST['cargo'])){
			$arreglo+=array('cargo'=>$_REQUEST['cargo']);
		}
		if (isset($_REQUEST['dependencia'])){
			$arreglo+=array('dependencia'=>$_REQUEST['dependencia']);
		}
		if (isset($_REQUEST['asunto'])){
			$arreglo+=array('asunto'=>$_REQUEST['asunto']);
		}
		if (isset($_REQUEST['idfirma'])){
			$arreglo+=array('idfirma'=>$_REQUEST['idfirma']);
		}
		if (isset($_REQUEST['idausencia'])){
			if(strlen($_REQUEST['idausencia'])>0){
				$arreglo+=array('idausencia'=>$_REQUEST['idausencia']);
			}
			else{
				$arreglo+=array('idausencia'=>NULL);
			}
		}
		if (isset($_REQUEST['idelabora'])){
			$arreglo+=array('idelabora'=>$_REQUEST['idelabora']);
		}
		if (isset($_REQUEST['observaciones'])){
			$arreglo+=array('observaciones'=>$_REQUEST['observaciones']);
		}
		if($documento=="comision"){
			$arreglo+=array('contestado'=>1);
		}

		if($id==0){
			$arreglo+=array('fcaptura'=>date("Y-m-d H:i:s"));
			$arreglo+=array('idcentro'=>$_SESSION['idcentro']);
			$arreglo+=array('anio'=>date("Y"));
			$x=$this->insert('yoficiosze', $arreglo);

			if(is_numeric($x)){
				$centro = $this->centro_c();
				$arreglo =array();
				$arreglo+=array('idoficio'=>$x);
				$arreglo+=array('idpersturna'=>$centro['idcorresp']);
				$arreglo+=array('fechturnado'=>date("Y-m-d H:i:s"));
				$arreglo+=array('fleido'=>date("Y-m-d H:i:s"));
				$arreglo+=array('leido'=>1);
				$arreglo+=array('estado'=>1);
				$arreglo+=array('contesto'=>0);
				$arreglo+=array('frecibido'=>date("Y-m-d H:i:s"));
				$a=$this->insert('yoficioszep', $arreglo);
			}
		}
		else{
			$x=$this->update('yoficiosze',array('idoficio'=>$id), $arreglo);
		}
		return $x;
	}
	public function agregaresp(){
		$x="";
		$arreglo =array();
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		if (isset($_REQUEST['recibio'])){
			$arreglo+=array('nombre'=>$_REQUEST['recibio']);
		}
		if (isset($_REQUEST['lugar'])){
			$arreglo+=array('lugar'=>$_REQUEST['lugar']);
		}
		if (isset($_REQUEST['observa'])){
			$arreglo+=array('observaciones'=>$_REQUEST['observa']);
		}
		if (isset($_REQUEST['frecibio'])){
			$fx=explode("-",$_REQUEST['frecibio']);
			$arreglo+=array('fecha'=>$fx['2']."-".$fx['1']."-".$fx['0']);
		}


		$arreglo+=array('idoficio'=>$id);
		$arreglo+=array('idcontesta'=>$_SESSION['idpersona']);

		$x.=$this->insert('yoficiosze_recibir', $arreglo);
		return $id;
	}
	public function borrarentrega(){
		if (isset($_POST['id'])){$id=$_POST['id'];}
		return $this->borrar('yoficiosze_recibir','idrecibir',$id);
	}
	public function marcadoofs(){
		$arreglo =array();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		$arreglo+=array('contestado'=>1);
		$this->update('yoficiosze',array('idoficio'=>$id), $arreglo);

		$arreglo =array();
		$arreglo+=array('contesto'=>1);
		$this->update('yoficioszep',array('idoficio'=>$id), $arreglo);
		return $id;
	}
	public function desmarcadoofs(){
		$arreglo =array();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		$arreglo+=array('contestado'=>0);
		$this->update('yoficiosze',array('idoficio'=>$id), $arreglo);
		return $id;
	}
	public function guardar_archivo(){
		$arreglo =array();
		$arreglo+=array('tipo'=>0);
		if (isset($_REQUEST['id'])){
			$arreglo+=array('idoficio'=>$_REQUEST['id']);
		}
		if (isset($_REQUEST['archivo'])){
			$arreglo+=array('direccion'=>$_REQUEST['archivo']);
		}
		$x=$this->insert('yoficiosze_archivos', $arreglo);
		return $x;
	}
	public function remitente_buscar(){
		$x="";
		if (isset($_REQUEST['valor'])){$valor=$_REQUEST['valor'];}

		$fecha=date("d-m-Y");
		$nuevafecha = strtotime ( '-6 month' , strtotime ( $fecha ) ) ;
		$fecha1 = date ( "Y-m-d" , $nuevafecha );
		$sql="SELECT DISTINCT destinatario, cargo, dependencia from yoficiosze where idcentro='".$_SESSION['idcentro']."' and (destinatario like '%$valor%') and fecha>='$fecha1' order by idoficio desc limit 5";
		$resp=$this->general($sql);
		$x.="<table class='table table-sm' style='font-size:13px' id='remitentetb'>";
		$x.="<thead><tr><th>Remitente</th><th>Cargo</th><th>Dependencia</th></tr></thead>";
		for($i=0;$i<count($resp);$i++){
			$x.="<tr id=".$resp[$i]['destinatario']." class='edit-t' >";
			$x.="<td >";
			$x.=trim($resp[$i]['destinatario']);
			$x.="</td>";
			$x.="<td >";
			$x.=$resp[$i]['cargo'];
			$x.="</td>";
			$x.="<td >";
			$x.=$resp[$i]['dependencia'];
			$x.="</td>";
			$x.="</tr>";
		}
		$x.="</table>";
		$x.="<button class='btn btn-outline-secondary btn-sm' onclick='$(\"#remitente_reg\").hide();' type='button'><i class='fas fa-sign-out-alt'/>Cerrar lista</button>";
		return $x;
	}
	public function borraturno(){
		if (isset($_REQUEST['id'])){$idoficiop=$_REQUEST['id'];}
		$a=$this->borrar('yoficioszep','idoficiop',$idoficiop);
		return $a;
	}
	public function turnar(){
		$x="";
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		$arreglo =array();
		if (isset($_REQUEST['aperson'])){
			$aperson=$_REQUEST['aperson'];
		}

		$horaturn=date("Y-m-d H:i:s");
		if($this->nivel_personal==7){
			$idpersona=$_SESSION['superior'];
		}
		else{
			$idpersona=$_SESSION['idpersona'];
		}
		$sql="SELECT * FROM yoficioszep where idoficio='$id' and idpersturna='$aperson'";
		$data = $this->general($sql);


		if(count($data)>0){
			$x.="No se puede turnar, ya ha sido turnado a esta persona";
		}
		else{
			$sql="SELECT * FROM yoficioszep where idoficio='$id' and (idpersturna='".$_SESSION['idpersona']."')";
			$xof = $this->general($sql);
			if(count($xof)==0){
				$sql="SELECT * FROM yoficioszep where idoficio='$id' and (idpersturna='".$_SESSION['superior']."')";
				$xof = $this->general($sql);
			}
			if(count($xof)==0){
				$x.="No se puede turnar";
			}
			else{
				$arreglo =array();

				$sql="SELECT * FROM yoficiosze where idoficio='$id'";
				$of = $this->general($sql);
				if($of[0]['documento']=="comision"){
					$arreglo+=array('contesto'=>1);
				}
				else{
					$arreglo+=array('contesto'=>0);
				}

				$arreglo+=array('fechturnado'=>$horaturn);
				$arreglo+=array('idpersturna'=>$aperson);
				$arreglo+=array('idoficio'=>$id);
				$arreglo+=array('idofp'=>$xof['0']['idoficiop']);
				$arreglo+=array('leido'=>0);
				$arreglo+=array('estado'=>0);
				$x=$this->insert('yoficioszep', $arreglo);

				$arreglo =array();
				$arreglo+=array('contesto'=>1);
				$x.=$this->update('yoficiosze',array('idoficiop'=>$xof['0']['idoficiop']), $arreglo);
			}
		}

		return $id;
	}
	public function envio_of(){
		$arreglo =array();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_POST['entrega'])){$entrega=$_POST['entrega'];}
		$arreglo+=array('entrega'=>$entrega);

		$this->update('yoficiosze',array('idoficio'=>$id), $arreglo);
		return $id;
	}
	public function cancelado_of(){
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_POST['entrega'])){$entrega=$_POST['entrega'];}

		$arreglo =array();
		$arreglo+=array('cancelado'=>$entrega);
		$arreglo+=array('contestado'=>0);
		$x=$this->update('yoficiosze',array('idoficio'=>$id), $arreglo);

		if($entrega==1){
			$arreglo =array();
			$arreglo+=array('contesto'=>1);
			$this->update('yoficioszep',array('idoficio'=>$id), $arreglo);
		}
		return $id;
	}
	public function solicita_turno(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		$sql="SELECT * FROM yoficiosp_solicitud where idpersona='".$_SESSION['idpersona']."' and idoficio='$id'";
		$stmt= $this->dbh->query($sql);
		if($stmt->rowCount()==0){
			$this->data=array();
			$arreglo=array();
			$arreglo+=array('idpersona'=>$_SESSION['idpersona']);
			$arreglo+=array('fecha'=>date("Y-m-d H:i:s"));
			$arreglo+=array('idoficio'=>$id);
			$arreglo+=array('estado'=>0);
			$x=$this->insert('yoficiosp_solicitud', $arreglo);
			return $x;
		}
		else{
			return "Ya fue solicitado anteriormente";
		}
	}
	public function solicitudes(){
		try{
			parent::set_names();
			$sql="select yoficiosp_solicitud.fecha, yoficiosp_solicitud.idoficio, yoficiosze.numero, personal.nombre FROM yoficiosp_solicitud left outer join yoficiosze on yoficiosze.idoficio=yoficiosp_solicitud.idoficio left outer join personal on personal.idpersona=yoficiosp_solicitud.idpersona where yoficiosp_solicitud.estado=0";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function ofturno($idoficio){
		try{
			parent::set_names();
			$this->data=array();
			$sql="select * FROM yoficiosp_solicitud where estado=0 and idoficio='$idoficio'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function turnasol(){
		$id=$_REQUEST['id'];
		$idrel=$_REQUEST['idrel'];
		$arreglo =array();

		$sql="SELECT * FROM yoficiosp_solicitud where id='$idrel'";
		$stmt= $this->dbh->query($sql);
		if($stmt->rowCount()>0){
			$row =$stmt->fetchObject();

			$sql="SELECT * FROM yoficioszep where idoficio='$id' limit 1";
			$turno= $this->dbh->query($sql);
			$row1 =$turno->fetchObject();

			$arreglo =array();
			$arreglo+=array('fechturnado'=>date("Y-m-d H:i:s"));
			$arreglo+=array('idoficio'=>$id);
			$arreglo+=array('leido'=>0);
			$arreglo+=array('estado'=>0);
			$arreglo+=array('contesto'=>0);
			$arreglo+=array('idpersturna'=>$row->idpersona);
			$arreglo+=array('idofp'=>$row1->idoficiop);
			$x=$this->insert('yoficioszep', $arreglo);

			$this->update('yoficiosze', array('idoficio'=>$id), array('contestado'=>0));

			$arreglo =array();
			$arreglo+=array('estado'=>1);
			$this->update('yoficiosp_solicitud',array('id'=>$idrel), $arreglo);

			return $x;
		}
		return $sql;
	}
	public function escanear(){
		$id=$_REQUEST['id'];
		$arreglo =array();
		$arreglo+=array('escanear'=>1);
		$arreglo+=array('idperscan'=>$_SESSION['idpersona']);
		$x=$this->update('yoficiosze',array('idoficio'=>$id), $arreglo);
		return $x;
	}
}
$db = new Salida();
if(strlen($function)>0){
	echo $db->$function();
}

?>
