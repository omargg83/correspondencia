<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

class Personal extends Salud{
	public $nivel_personal;
	public $nivel_captura;

	public function __construct(){
		parent::__construct();

		$sql="SELECT nivel,captura FROM personal_permiso where idpersona='".$_SESSION['idpersona']."' and nombre='PERSONAL'";
		$stmt= $this->dbh->query($sql);

		if($stmt->rowCount()==0){
			$this->nivel_personal=9;
			$this->nivel_captura=0;
		}
		else{
			$row =$stmt->fetchObject();
			$this->nivel_personal=$row->nivel;
			$this->nivel_captura=$row->captura;
		}
		$this->doc="a_archivos/personal/";
	}
	public function plantilla($valor){
		global $nivel_personal;
		$filtro="";
		try{
			parent::set_names();
			$this->accesox=array();
			if(strlen($valor)>0){
				$filtro=" (personal.nombre like '%$valor%' or area.area like '%$valor%') ";
			}
			if ($this->nivel_personal==0 or $_SESSION['administrador']==1){
				if(strlen($valor)>0){ $filtro=" where ".$filtro;}
				else{ $filtro="where personal.idarea=".$_SESSION['idarea'];}
				$sql="SELECT personal.idpersona,nombre,personal.idarea,area.area,personal.estudio,personal_orga.orden, personal_orga.cargo, personal.file_foto FROM personal left outer join area on area.idarea=personal.idarea left outer join personal_orga on personal_orga.id=personal.idcargo $filtro order by area.orden,personal_orga.orden,personal.idpersona";
			}
			else if ( $this->nivel_personal==3 or $this->nivel_personal==2){
				$listaar="";
				$sql="select * from area where idarea='".$_SESSION['idarea']."' or sub='".$_SESSION['idarea']."'";
				foreach ($this->dbh->query($sql) as $res){
					$listaar.=$res['idarea'].",";
				}
				$listaar=substr($listaar,0,strlen($listaar)-1);
				$sql="SELECT personal.idpersona,nombre,personal.idarea,area.area,personal.estudio,personal_orga.orden, personal_orga.cargo, personal.file_foto FROM personal left outer join area on area.idarea=personal.idarea left outer join personal_orga on personal_orga.id=personal.idcargo where personal.idarea in($listaar) $filtro and area.idarea<100 order by personal.idarea,personal_orga.orden,personal.idpersona";
			}
			else if($this->nivel_personal==4 or $this->nivel_personal==10 or $this->nivel_personal==3){
				if(strlen($valor)>0){ $filtro=" where area.idcentro='".$_SESSION['idcentro']."' and ".$filtro;}
				else{ $filtro=" where area.idarea='".$_SESSION['idarea']."'"; }
				$sql="SELECT personal.idpersona,nombre,personal.idarea,area.area,personal.estudio,personal_orga.orden, personal_orga.cargo, personal.file_foto FROM personal left outer join area on area.idarea=personal.idarea left outer join personal_orga on personal_orga.id=personal.idcargo $filtro order by area.orden,personal_orga.orden,personal.idpersona";
			}
			else{
				$sql="SELECT personal.idpersona,nombre,personal.idarea,area.area,personal.estudio,personal_orga.cargo, personal.file_foto FROM personal left outer join area on area.idarea=personal.idarea left outer join personal_orga on personal_orga.id=personal.idcargo where personal.idpersona='".$_SESSION['idpersona']."' order by area.orden,personal_orga.orden,personal.idpersona";
			}
			foreach ($this->dbh->query($sql) as $res){
				$this->accesox[]=$res;
			}
			return $this->accesox;
			$this->dbh=null;
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}

	public function puesto(){
		$sql="select * from personal_puesto order by puesto asc";
		foreach ($this->dbh->query($sql) as $res){
            $this->puestox[]=$res;
        }
        return $this->puestox;
        $this->dbh=null;
	}
	public function cargo($id,$t_area){
		$sql="SELECT * FROM personal_orga WHERE NOT EXISTS (SELECT * FROM personal WHERE personal.idcargo = personal_orga.id) and personal_orga.idarea='$t_area'
			UNION
			SELECT personal_orga.* FROM personal_orga left outer join personal on personal.idcargo=personal_orga.id where idpersona='$id'";
			$this->xcargo=array();
		foreach ($this->dbh->query($sql) as $res){
            $this->xcargo[]=$res;
        }
        return $this->xcargo;
        $this->dbh=null;
	}
	public function cargoedit($idcargo){
		$sql="SELECT * FROM personal_orga where id='$idcargo'";
		foreach ($this->dbh->query($sql) as $res){
            $this->xcargo=$res;
        }
        return $this->xcargo;
        $this->dbh=null;
	}
	public function cargos(){
		$sql="SELECT personal_orga.*,personal.nombre FROM personal_orga left outer join personal on personal.idcargo=personal_orga.id order by personal_orga.idarea";
		foreach ($this->dbh->query($sql) as $res){
            $this->xcargo[]=$res;
        }
        return $this->xcargo;
        $this->dbh=null;

	}
	public function superior($id){
			try{
				parent::set_names();
				$sql="select * from personal where idcargo='$id'";
				foreach ($this->dbh->query($sql) as $res){
					$this->accesox=$res;
				}
				return $this->accesox;
				$this->dbh=null;
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
	public function centro($idarea){
			try{
				parent::set_names();
				$this->accesox="";
				 $sql="select titulo, idcentro, area, estado from area where idarea='".$idarea."'";
				foreach ($this->dbh->query($sql) as $res){
					$this->accesox=$res;
				}
				return $this->accesox;
				$this->dbh=null;
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
	public function cambio_user($id){
		try{
				self::set_names();

				$sql="SELECT nombre,usuario,pass,estudio,idpersona,file_foto,personal.idarea,idcargo,personal_orga.cargo,personal_orga.parentid,personal_orga.orden as puesto,idfondo FROM personal left outer join personal_orga on personal_orga.id=personal.idcargo where idpersona='$id'";
				foreach ($this->dbh->query($sql) as $res){
					$this->accesox=$res;
				}
				return $this->accesox;
				$this->dbh=null;
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
	}
	public function guardar(){
		$x="";
		///////////////////////
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		$arreglo =array();
		if (isset($_REQUEST['nombre'])){
			$arreglo+=array('nombre'=>$_REQUEST['nombre']);
		}
		if (isset($_REQUEST['rfc'])){
			$arreglo+=array('rfc'=>$_REQUEST['rfc']);
		}
		if (isset($_REQUEST['prof'])){
			$arreglo+=array('estudio'=>$_REQUEST['prof']);
		}
		if (isset($_REQUEST['idarea'])){
			$idarea=$_REQUEST['idarea'];
			$arreglo+=array('idarea'=>$idarea);
		}
		if (isset($_REQUEST['idcargo']) and strlen($_REQUEST['idcargo'])>0){
			$arreglo+=array('idcargo'=>$_REQUEST['idcargo']);
		}
		else{
			$arreglo+=array('idcargo'=>NULL);
		}
		if (isset($_REQUEST['idpuesto'])){
			$arreglo+=array('idpuesto'=>$_REQUEST['idpuesto']);
		}
		if (isset($_REQUEST['nombra'])){
			$arreglo+=array('nombra'=>$_REQUEST['nombra']);
		}
		if (isset($_REQUEST['idprograma'])){
			$arreglo+=array('idprogra'=>$_REQUEST['idprograma']);
		}

		if (isset($_REQUEST['idfuncion'])){
			$arreglo+=array('idfuncion'=>$_REQUEST['idfuncion']);
		}

		if (isset($_REQUEST['correo'])){
			$correo=trim($_REQUEST['correo']);
			$arreglo+=array('correo'=>$correo);
		}
		if (isset($_REQUEST['usuariot'])){
			$arreglo+=array('usuario'=>$_REQUEST['usuariot']);
		}

		if($id==0){
			$sql="select * from personal where correo='$correo'";
			$buscar=$this->general($sql);
			if(count($buscar)==0){
				$arreglo+=array('fecha'=>date("Y-m-d"));
				$arreglo+=array('autoriza'=>1);
				$x=$this->insert('personal', $arreglo);
				$arreglo =array();
				$arreglo+=array('idpersona'=>$x);
				$arreglo+=array('nivel'=>9);
				$arreglo+=array('acceso'=>1);
				$arreglo+=array('captura'=>0);
				$arreglo+=array('nombre'=>"PERSONAL");
				$this->insert('personal_permiso', $arreglo);
			}
			else{
				$x.="Ya existe usuario con esta información favor de verificar ";
			}
		}
		else{
			if($_SESSION['administrador']==1){
				if (isset($_REQUEST['autoriza'])){
					$arreglo+=array('autoriza'=>$_REQUEST['autoriza']);
				}
				else{
					$arreglo+=array('autoriza'=>0);
				}
			}
			else{
				if($idarea<100){
					$arreglo+=array('autoriza'=>1);
				}
			}

			$x.=$this->update('personal',array('idpersona'=>$id), $arreglo);
			$sql="SELECT * FROM personal_permiso where idpersona='$id'";
			$stmt= $this->dbh->query($sql);

			if($stmt->rowCount()==0){
				$arreglo =array();
				$arreglo+=array('idpersona'=>$id);
				$arreglo+=array('nivel'=>9);
				$arreglo+=array('acceso'=>1);
				$arreglo+=array('captura'=>0);
				$arreglo+=array('nombre'=>"PERSONAL");
				$this->insert('personal_permiso', $arreglo);
			}
		}
		return $x;
	}
	public function password(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		if (isset($_REQUEST['pass1'])){$pass1=$_REQUEST['pass1'];}
		if (isset($_REQUEST['pass2'])){$pass2=$_REQUEST['pass2'];}
		if(trim($pass1)==($pass2)){
			$arreglo=array();
			$passPOST=md5(trim($pass1));
			$arreglo=array('pass'=>$passPOST);
			$x=$this->update('personal',array('idpersona'=>$id), $arreglo);
			return $x;
		}
		else{
			return "La contraseña no coincide";
		}
	}
	public function permisos(){
		$x="";

		$arreglo =array();

		if (isset($_REQUEST['id'])) {
			$id=$_REQUEST['id'];
		}
		if (isset($_REQUEST['acceso'])) {
			$acceso=$_REQUEST['acceso'];
		}
		else{
			$acceso=0;
		}
		if (isset($_REQUEST['aplicacion'])) {
			$aplicacion=$_REQUEST['aplicacion'];
			$arreglo+=array('nombre'=>$_REQUEST['aplicacion']);
		}

		$arreglo+=array('acceso'=>$acceso);

		if (isset($_REQUEST['captura'])) $arreglo+=array('captura'=>$_REQUEST['captura']);
		if (isset($_REQUEST['nivelx'])) $arreglo+=array('nivel'=>$_REQUEST['nivelx']);

		$sql="select * from personal_permiso where idpersona='$id' and nombre='$aplicacion'";
		$a=$this->general($sql);

		$arreglo+=array('idpersona'=>$id);

		if(count($a)>0){
			$x.=$this->update('personal_permiso',array('idpermiso'=>$a[0]['idpermiso']),$arreglo);
		}
		else{
			$x.=$this->insert('personal_permiso', $arreglo);
		}
		return $id;
	}
	public function borrapermiso(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		return $this->borrar('personal_permiso','idpermiso',$id);
	}
	public function borrar_cargo(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		return $this->borrar('personal_orga','id',$id);
	}
	public function guarda_admin(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		if (isset($_REQUEST['autoriza'])){
			$autoriza=$_REQUEST['autoriza'];
		}
		else{
			$autoriza=0;
		}
		$arreglo=array('autoriza'=>$autoriza);
		$x=$this->update('personal',array('idpersona'=>$id), $arreglo);
		return $x;
	}
	public function cambiar_user(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}

		$CLAVE=$this->cambio_user($id);

		$_SESSION['autoriza']=1;
		$_SESSION['nombre']=$CLAVE['nombre'];
		$_SESSION['usuario'] = $CLAVE['usuario'];
		$_SESSION['pass'] = $CLAVE['pass'];
		$_SESSION['puesto']=$CLAVE['puesto'];
		$_SESSION['cargo']=$CLAVE['cargo'];

		$superior = $this->superior($CLAVE['parentid']);
		$_SESSION['superior']=$superior['idpersona'];

		$_SESSION['estudio']=$CLAVE['estudio'];
		$_SESSION['idpersona']=$CLAVE['idpersona'];
		$_SESSION['idarea']=$CLAVE['idarea'];
		$_SESSION['foto']=$CLAVE['file_foto'];
		$_SESSION['cargo']=$CLAVE['cargo'];

		$fecha=date("Y-m-d");
		list($anyo,$mes,$dia) = explode("-",$fecha);

		$_SESSION['avatar']="librerias/img/1220140826130455.png";
		$_SESSION['n_sistema']="Salud";
		$centro = $this->centro($CLAVE['idarea']);

		$_SESSION['idcentro']=$centro['idcentro'];
		$_SESSION['anio']=date("Y");
		$_SESSION['mes']=date("m");
		$_SESSION['dia']=date("d");
		$_SESSION['nocuenta'] = 1;
		$_SESSION['ventana'] = "";

		$_SESSION['foco']=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
		$_SESSION['cfondo']="white";
		return "1";
	}
	public function guardar_cargo(){

		$arreglo =array();
		$x="";
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		if (isset($_REQUEST['idpersona'])){$idpersona=$_REQUEST['idpersona'];}
		if (isset($_REQUEST['itemtype'])){
			$arreglo+=array('itemtype'=>$_REQUEST['itemtype']);
		}
		if (isset($_REQUEST['cargox'])){
			$arreglo+=array('cargo'=>$_REQUEST['cargox']);
		}
		if (isset($_REQUEST['idarea'])){
			$arreglo+=array('idarea'=>$_REQUEST['idarea']);
		}
		if (isset($_REQUEST['idsuperior'])){
			$sql="SELECT idcargo FROM personal where idpersona='".$_REQUEST['idsuperior']."' ";
			$cargo=$this->general($sql);
			$arreglo+=array('parentid'=>$cargo[0]['idcargo']);
		}
		if($id==0){
			$x.=$this->insert('personal_orga', $arreglo);
		}
		else{
			$x.=$this->update('personal_orga',array('id'=>$id), $arreglo);
		}
		return $idpersona;
	}
	public function baja(){
		$arreglo =array();
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}

		$this->borrar('personal_permiso','idpersona',$id);

		$arreglo+=array('idarea'=>150);
		$arreglo+=array('idcargo'=>null);
		$arreglo+=array('autoriza'=>0);
		$x=$this->update('personal',array('idpersona'=>$id), $arreglo);
		return "$x";
	}
	public function guardar_documento(){
		$arreglo =array();
		$arreglo+=array('idpersonal'=>$_REQUEST['id']);
		$arreglo+=array('direccion'=>$_REQUEST['archivo']);

		$x=$this->insert('personal_docu',$arreglo);
		return $x;
	}
	public function activar_usuario(){
		$arreglo =array();
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		$arreglo+=array('autoriza'=>1);
		$x=$this->update('personal',array('idpersona'=>$id), $arreglo);
		return $x;
	}
	public function modulos(){
		$x="";
		$x.= "<option value='' selected></option>";
		$x.= "<optgroup label='SUBSECRETARIA'>";
		$x.= "<option value='PERSONAL'>PERSONAL</option>";
		$x.= "<option value='CORRESPONDENCIA'>CORRESPONDENCIA</option>";
		$x.= "<option value='CORRESPREGISTRO'>CORRESP REGISTRO</option>";
		return $x;
	}
	public function nivelx($val){
		if($val==0) {$nivel="0-Administrador";}
		if($val==1) {$nivel="1-Subsecretarío";}
		if($val==2) {$nivel="2-Dirección";}
		if($val==3) {$nivel="3-Subdirector";}
		if($val==4) {$nivel="4-Coordinador Administrativo";}
		if($val==5) {$nivel="5-Jefe Depto.";}
		if($val==6) {$nivel="6-Coordinador";}
		if($val==7) {$nivel="7-Secretaria";}
		if($val==8) {$nivel="8-Chofer";}
		if($val==9) {$nivel="9-Personal";}
		if($val==10) {$nivel="10-Informatica";}
		if($val==11) {$nivel="11-Administrador del sistema";}
		if($val==12) {$nivel="12-Oficialia";}
		return $nivel;
	}
	public function correo(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		if (isset($_REQUEST['correo'])){$correo=$_REQUEST['correo'];}
		$arreglo=array();
		$arreglo=array('correo'=>$correo);
		$x=$this->update('personal',array('idpersona'=>$id), $arreglo);
		return $x;
	}
}
$db = new Personal();
if(strlen($function)>0){
	echo $db->$function();
}

?>
