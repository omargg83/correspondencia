<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

/*
$method=$_SERVER['REQUEST_METHOD'];
echo $method;
$url=$_SERVER['REQUEST_URI'];
echo "uri:".$url;
$method=$_SERVER['REQUEST_METHOD'];

$url_components = parse_url($url);
parse_str($url_components['query'], $params);

// Display result
echo ' Hi '.$params['query'];

$resource = array_shift($paths);
if($resource == 'clients'){
    $name = array_shift($paths);
    if(empty($name)){
      //  $this->handle_base($method);
    } else {
        //$this->handle_name($method, $name);
    }
} else {
    // Sólo se aceptan resources desde 'clients'
    //header('HTTP/1.1 404 Not Found');
}


switch($method){
    case 'PUT':
        $this->create_contact($name);
        break;
    case 'DELETE':
        $this->delete_contact($name);
        break;
    case 'GET':
        $this->display_contact($name);
        break;
    default:
        header('HTTP/1.1 405 Method not allowed');
        header('Allow: GET, PUT, DELETE');
        break;
}
*/
class Corresp extends Salud{
	public $nivel_personal;
	public $nivel_captura;
	public $data;

	public function __construct(){
		parent::__construct();

		$sql="SELECT nivel,captura FROM personal_permiso where idpersona='".$_SESSION['idpersona']."' and nombre='CORRESPONDENCIA'";
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
		$this->doc="a_archivos/a_corresp/";
	}
	public function c_entrada(){						////////////////COMBO DE OFICIOS
		try{
			parent::set_names();
			$fecha=date("Y-m-d");
			$nuevafecha = strtotime ( '-40 day' , strtotime ( $fecha ) ) ;
			$fecha1 = date ( "Y-m-d" , $nuevafecha );
			$anio=$_SESSION['anio']-2;

			if($this->nivel_personal==7 or $this->nivel_personal==0){
					$sql="SELECT yoficios.idoficio, yoficios.numero, yoficios.numoficio, remitente, contestado, fechaofi FROM yoficiosp LEFT OUTER JOIN yoficios ON yoficios.idoficio = yoficiosp.idoficio WHERE yoficiosp.estado = 1 and (yoficiosp.idpersturna = '".$_SESSION['superior']."' OR yoficiosp.idpersturna = '".$_SESSION['idpersona']."') and ((yoficios.year>='$anio' and yoficios.contestado= 0) or (yoficios.fechaofi > '$fecha1') ) ORDER BY yoficios. YEAR DESC, yoficios.numero DESC";
			}
			else{
					$sql="SELECT yoficios.idoficio, yoficios.numero, yoficios.numoficio, remitente, contestado, fechaofi FROM yoficiosp LEFT OUTER JOIN yoficios ON yoficios.idoficio = yoficiosp.idoficio WHERE yoficiosp.estado = 1 and yoficiosp.idpersturna = '".$_SESSION['idpersona']."' and ((yoficios.year>='$anio' and yoficios.contestado= 0) or (yoficios.fechaofi > '$fecha1') ) ORDER BY yoficios. YEAR DESC, yoficios.numero DESC";
			}
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function c_listado(){						//////////////////LISTADO DE OFICIOS
		try{
			parent::set_names();
			$anio=$_SESSION['anio']-3;
			$sql="select yoficios.numoficio, yoficios.numero, yoficios.fechaofi, yoficios.idoficio, yoficios.remitente, yoficios.asunto, yoficios.texto, yoficios.clasificacion, yoficios.contestado, yoficiosp.idrecibido, yoficiosp.frecibido, yoficiosp.firma, yoficios.anexos, yoficios.urgente, yoficios.atencion, yoficios.conocimiento, yoficios.acuerdo, yoficios.oficio, yoficios.archivar FROM yoficiosp LEFT OUTER JOIN yoficios on yoficiosp.idoficio=yoficios.idoficio where yoficios.year>$anio and yoficiosp.idpersturna='".$_SESSION['idpersona']."' and yoficiosp.contesto=0 and yoficiosp.estado=1";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function c_superiorlista(){						//////////////////LISTADO DE OFICIOS del superior
		try{
			parent::set_names();
			$anio=$_SESSION['anio']-2;
			$sql="select yoficios.numoficio, yoficios.numero, yoficios.fechaofi, yoficios.idoficio, yoficios.remitente, yoficios.asunto, yoficios.texto, yoficios.clasificacion, yoficios.contestado, yoficiosp.idrecibido, yoficiosp.frecibido, yoficiosp.firma, yoficios.anexos, yoficios.urgente, yoficios.atencion, yoficios.conocimiento, yoficios.acuerdo, yoficios.oficio, yoficios.archivar FROM yoficiosp LEFT OUTER JOIN yoficios on yoficiosp.idoficio=yoficios.idoficio where yoficios.year>='$anio' and yoficiosp.idpersturna='".$_SESSION['superior']."' and yoficiosp.contesto=0 and yoficiosp.estado=1 order by yoficios.idoficio desc";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function c_todos(){
		try{
			parent::set_names();
			$fecha=date("Y-m-d");
			$nuevafecha = strtotime ( '-4 month' , strtotime ( $fecha ) ) ;
			$fecha1 = date ( "Y-m-d" , $nuevafecha );

			if(($this->nivel_personal==7 or $this->nivel_personal==0)){
				$sql="select * FROM yoficios yof LEFT OUTER JOIN yoficiosp on yoficiosp.idoficio=yof.idoficio
				where (yoficiosp.idpersturna='".$_SESSION['idpersona']."' or yoficiosp.idpersturna='".$_SESSION['superior']."') and yof.fechaofi>'$fecha1' GROUP BY yof.IDOFICIO order by yof.idoficio desc";
			}
			else{
				$sql="select * FROM yoficios yof LEFT OUTER JOIN yoficiosp on yoficiosp.idoficio=yof.idoficio
				where yoficiosp.idpersturna='".$_SESSION['idpersona']."' and yof.fechaofi>'$fecha1' GROUP BY yof.IDOFICIO order by yof.idoficio desc";
			}

			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function c_buscar($oficio){
		try{
			parent::set_names();
			$arreglo=array();
			$arreglo+=array('idpersona'=>$_SESSION['idpersona']);
			$arreglo+=array('fecha'=>date("Y-m-d H:i:s"));
			$arreglo+=array('monitor'=>"Buscar $oficio");
			$arreglo+=array('modulo'=>"Correspondencia entrada");
			$this->insert('acceso', $arreglo);

			if($this->nivel_personal==0){
				$sql="SELECT yoficios.numoficio, yoficios.numero, yoficios.fechaofi, yoficios.idoficio, yoficios.remitente, yoficios.asunto, yoficios.clasificacion, yoficios.contestado, yoficiosp.idrecibido, yoficiosp.frecibido, yoficiosp.firma, yoficios.texto, yoficios.anexos, yoficios.urgente, yoficios.atencion, yoficios.conocimiento, yoficios.acuerdo, yoficios.oficio, yoficios.archivar FROM yoficios left outer join yoficiosp on yoficios.idoficio=yoficiosp.idoficio where (remitente LIKE '%$oficio%') or (asunto LIKE '%$oficio%') or (yoficios.numoficio LIKE '%$oficio%') or (yoficios.numero LIKE '%$oficio%') GROUP BY yoficios.IDOFICIO order by yoficios.idoficio desc limit 300";
			}
			else if($this->nivel_personal==7){
				$sql="SELECT yoficios.numoficio, yoficios.numero, yoficios.fechaofi, yoficios.idoficio, yoficios.remitente, yoficios.asunto, yoficios.clasificacion, yoficios.contestado, yoficiosp.idrecibido, yoficiosp.frecibido, yoficiosp.firma, yoficios.texto, yoficios.anexos, yoficios.urgente, yoficios.atencion, yoficios.conocimiento, yoficios.acuerdo, yoficios.oficio, yoficios.archivar FROM yoficios left outer join yoficiosp on yoficios.idoficio=yoficiosp.idoficio WHERE
				(remitente LIKE '%$oficio%' or asunto LIKE '%$oficio%' or yoficios.numoficio LIKE '%$oficio%' or yoficios.numero LIKE '%$oficio%')
				and ( yoficiosp.idpersturna = ".$_SESSION['idpersona']." or yoficiosp.idpersturna = ".$_SESSION['superior'].") and yoficiosp.estado=1 GROUP BY yoficios.IDOFICIO order by yoficios.idoficio desc  limit 300";
			}
			else{
				$sql="SELECT yoficios.numoficio, yoficios.numero, yoficios.fechaofi, yoficios.idoficio, yoficios.remitente, yoficios.asunto, yoficios.clasificacion, yoficios.contestado, yoficiosp.idrecibido, yoficiosp.frecibido, yoficiosp.firma, yoficios.texto, yoficios.anexos, yoficios.urgente, yoficios.atencion, yoficios.conocimiento, yoficios.acuerdo, yoficios.oficio, yoficios.archivar FROM yoficios left outer join yoficiosp on yoficios.idoficio=yoficiosp.idoficio WHERE (remitente LIKE '%$oficio%' or asunto LIKE '%$oficio%' or yoficios.numoficio LIKE '%$oficio%' or yoficios.numero LIKE '%$oficio%') and ( yoficiosp.idpersturna = ".$_SESSION['idpersona'].") and yoficiosp.estado=1 GROUP BY yoficios.IDOFICIO order by yoficios.idoficio desc limit 300";
			}
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function numero($table,$id){
		try{
			parent::set_names();
			$sql = "SELECT MAX($id) + 1 FROM $table where year='".$_SESSION['anio']."' and idcentro='".$_SESSION['idcentro']."'";
			$statement = $this->dbh->prepare($sql);
			$statement->execute();
			$item_id = $statement->fetchColumn();
			return $item_id;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function numero2(){
		try{
			parent::set_names();
			$sql = "SELECT MAX(numero) + 1 FROM yoficios where year='".$_SESSION['anio']."' and idcentro='".$_SESSION['idcentro']."'";
			$statement = $this->dbh->prepare($sql);
			$statement->execute();
			$item_id = $statement->fetchColumn();
			return $item_id;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function c_oficio($id){
		try{
			$this->corregir($id);
			$sql="SELECT *,datediff(now(),yoficios.frecibido) as diferencia FROM yoficios where idoficio='$id'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetch();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function c_archivos($id){
		try{
			parent::set_names();
			$sql="SELECT * FROM yoficios_archivos where idoficio='$id'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function c_filecontesta($id){
		try{
			parent::set_names();
			$sql="select * from yoficios_archivosresp where yoficios_archivosresp.idoficio='$id'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function c_superior($id){
		try{
			parent::set_names();
			$sql="SELECT * FROM yoficiosp where idoficio='$id' and (idpersturna='".$_SESSION['idpersona']."' or idpersturna='".$_SESSION['superior']."') and contesto=0";
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
	public function corregir($id){
		try{
			$x="";
			parent::set_names();

			$sql="select * from yoficiosp where idoficio='$id' and contesto=0";
			$contestado = $this->dbh->prepare($sql);
			$contestado->execute();
			if($contestado->rowCount()>0){
				$arreglo=array('contestado'=>0);
				$this->update('yoficios',array('idoficio'=>$id), $arreglo);
			}
			else{
				$arreglo=array('contestado'=>1);
				$this->update('yoficios',array('idoficio'=>$id), $arreglo);
			}

			///////////////////////////////////////////

			$sql="update yoficiosp set estado=1 where idoficio='$id' and contesto=1";
			$firma_auto = $this->dbh->prepare($sql);
			$firma_auto->execute();

			///////////////////////////////////////////
			$sql="SELECT idoficiop, contesta, original, fechturnado, fleido, nombre, file_fototh, contesto, fcontesta, observacionest FROM yoficiosp
			left outer join personal on personal.idpersona=yoficiosp.idpersturna
			where idoficio='$id' order by idoficiop asc limit 1";

			$statement = $this->dbh->prepare($sql);
			$statement->execute();

			$resultado = $statement->fetchAll();
			$item_id=$resultado[0]['idoficiop'];

			$sql="SELECT idoficiop,original,fechturnado,fleido,fcontesta,contesta,idofp,contesto,nombre,file_fototh, observacionest FROM yoficiosp left outer join personal on personal.idpersona=yoficiosp.idpersturna where idofp='$item_id'";
			$rex = $this->dbh->query($sql);

			if($rex->rowCount()>0){
				if($resultado[0]['contesto']==0){
					$arreglo=array('contesto'=>1);
					$this->update('yoficiosp',array('idoficiop'=>$item_id), $arreglo);
				}
				$nivel1=$rex->fetchAll();
				$x.=$this->turnoscorregidos($nivel1);
			}
			else{
				if(strlen($resultado[0]['contesta'])==0){
					$arreglo=array('contesto'=>0);
					$this->update('yoficiosp',array('idoficiop'=>$item_id), $arreglo);
				}
			}

			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function turnoscorregidos($nivel1){
		$x="";
		for($i=0;$i<count($nivel1);$i++){
			$item_id=$nivel1[$i]['idoficiop'];

			$sql="SELECT original,fechturnado,fleido,fcontesta,contesta,idofp,contesto,idoficiop,nombre,file_fototh, observacionest FROM yoficiosp left outer join personal on personal.idpersona=yoficiosp.idpersturna where idofp='".$nivel1[$i]['idoficiop']."'";
			$rex = $this->dbh->query($sql);

			if($rex->rowCount()>0){
				if($nivel1[$i]['contesto']==0){
					$arreglo=array('contesto'=>1);
					$this->update('yoficiosp',array('idoficiop'=>$item_id), $arreglo);
				}
				$nivel1=$rex->fetchAll();
				$x.=$this->turnoscorregidos($nivel1);
			}
			else{
				if(strlen($nivel1[$i]['contesta'])==0 and $nivel1[$i]['contesto']==1){
					$arreglo=array('contesto'=>0);
					$arreglo+=array('fcontesta'=>null);
					$this->update('yoficiosp',array('idoficiop'=>$item_id), $arreglo);
				}
			}
		}
		return $x;
	}
	public function buscar_todo($oficio){
		try{
			parent::set_names();

			$anio=$_SESSION['anio']-2;
			$sql="SELECT yoficios.numoficio, yoficios.numero, yoficios.fechaofi, yoficios.idoficio, yoficios.remitente, yoficios.asunto, yoficios.clasificacion, yoficios.contestado, yoficiosp.idrecibido, yoficiosp.frecibido, yoficiosp.firma, yoficios.texto, yoficios.anexos, yoficios.urgente, yoficios.atencion, yoficios.conocimiento, yoficios.acuerdo, yoficios.oficio, yoficios.archivar FROM yoficios left outer join yoficiosp on yoficios.idoficio=yoficiosp.idoficio where year>=$anio and ((remitente LIKE '%$oficio%') or (asunto LIKE '%$oficio%') or (yoficios.numoficio LIKE '%$oficio%') or (yoficios.numero LIKE '%$oficio%')) GROUP BY yoficios.IDOFICIO order by yoficios.idoficio desc limit 20";

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

			if (isset($_REQUEST['numoficio'])){
				$arreglo+=array('numoficio'=>$_REQUEST['numoficio']);
			}
			if (isset($_REQUEST['fechaofi'])){
				$fx=explode("-",$_REQUEST['fechaofi']);
				$arreglo+=array('fechaofi'=>$fx['2']."-".$fx['1']."-".$fx['0']);
				$arreglo+=array('year'=>$fx['2']);
			}
			if (isset($_REQUEST['folio'])){
				$arreglo+=array('folio'=>$_REQUEST['folio']);
			}
			if (isset($_REQUEST['asunto'])){
				$arreglo+=array('asunto'=>$_REQUEST['asunto']);
			}
			if (isset($_REQUEST['texto'])){
				$arreglo+=array('texto'=>$_REQUEST['texto']);
			}
			if (isset($_REQUEST['remitente'])){
				$arreglo+=array('remitente'=>$_REQUEST['remitente']);
			}
			if (isset($_REQUEST['cargo'])){
				$arreglo+=array('cargo'=>$_REQUEST['cargo']);
			}
			if (isset($_REQUEST['dependencia'])){
				$arreglo+=array('dependencia'=>$_REQUEST['dependencia']);
			}
			if (isset($_REQUEST['anexos'])){
				$arreglo+=array('anexos'=>$_REQUEST['anexos']);
			}
			if (isset($_REQUEST['frecibido'])){
				$fx=explode("-",$_REQUEST['frecibido']);
				$arreglo+=array('frecibido'=>$fx['2']."-".$fx['1']."-".$fx['0']." ".$_REQUEST['hrecibido']);
			}
			if (isset($_REQUEST['recibido'])){
				$arreglo+=array('recibido'=>$_REQUEST['recibido']);
			}
			if (isset($_REQUEST['clasificacion'])){
				$arreglo+=array('clasificacion'=>$_REQUEST['clasificacion']);
			}
			if (isset($_REQUEST['urgente'])){
				$arreglo+=array('urgente'=>$_REQUEST['urgente']);
			}
			else{
				$arreglo+=array('urgente'=>0);
			}
			if (isset($_REQUEST['atencion'])){
				$arreglo+=array('atencion'=>$_REQUEST['atencion']);
			}
			else{
				$arreglo+=array('atencion'=>0);
			}
			if (isset($_REQUEST['conocimiento'])){
				$arreglo+=array('conocimiento'=>$_REQUEST['conocimiento']);
			}
			else{
				$arreglo+=array('conocimiento'=>0);
			}
			if (isset($_REQUEST['acuerdo'])){
				$arreglo+=array('acuerdo'=>$_REQUEST['acuerdo']);
			}
			else{
				$arreglo+=array('acuerdo'=>0);
			}
			if (isset($_REQUEST['oficio'])){
				$arreglo+=array('oficio'=>$_REQUEST['oficio']);
			}
			else{
				$arreglo+=array('oficio'=>0);
			}
			if (isset($_REQUEST['archivar'])){
				$arreglo+=array('archivar'=>$_REQUEST['archivar']);
			}
			else{
				$arreglo+=array('archivar'=>0);
			}

			if($id==0){
				$sql = "SELECT MAX(numero) + 1 FROM yoficios where year='".$_SESSION['anio']."' and idcentro='".$_SESSION['idcentro']."'";
				$statement = $this->dbh->prepare($sql);
				$statement->execute();
				$arreglo+=array('numero'=>$statement->fetchColumn());
				$arreglo+=array('fcaptura'=>date("Y-m-d H:i:s"));
				$arreglo+=array('contestado'=>0);
				$arreglo+=array('capturo'=>$_SESSION['idpersona']);
				$arreglo+=array('idcentro'=>$_SESSION['idcentro']);
				$centro = $this->centro_c();
				$arreglo+=array('dirigido'=>$centro['idcorresp']);
				$idoficio=$this->insert('yoficios', $arreglo);

				if(is_numeric($idoficio)){
					$arreglo =array();
					$arreglo+=array('idoficio'=>$idoficio);
					if ($this->nivel_personal==12){
						$arreglo+=array('idpersturna'=>$_SESSION['idpersona']);
					}
					else{
						$arreglo+=array('idpersturna'=>$centro['idcorresp']);
					}
					$arreglo+=array('fechturnado'=>date("Y-m-d H:i:s"));
					$arreglo+=array('fleido'=>date("Y-m-d H:i:s"));
					$arreglo+=array('leido'=>1);
					$arreglo+=array('estado'=>1);
					$arreglo+=array('frecibido'=>date("Y-m-d H:i:s"));
					$arreglo+=array('idrecibido'=>$_SESSION['idpersona']);
					$a=$this->insert('yoficiosp', $arreglo);
				}
				$x=$idoficio;
			}
			else{
				if (isset($_REQUEST['numero'])){
					$arreglo+=array('numero'=>$_REQUEST['numero']);
				}
				$arreglo+=array('modificado'=>date("Y-m-d H:i:s"));
				$arreglo+=array('modifica'=>$_SESSION['idpersona']);
				$x.=$this->update('yoficios',array('idoficio'=>$id), $arreglo);
			}

			return $x;
		}
	public function turnar(){
		$x="";
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		$arreglo =array();
		if (isset($_REQUEST['aperson'])){
			$aperson=$_REQUEST['aperson'];
		}
		if (isset($_REQUEST['observa2'])){
			$observa2=$_REQUEST['observa2'];
		}


		$horaturn=date("Y-m-d H:i:s");
		if($this->nivel_personal==7){
			$idpersona=$_SESSION['superior'];
		}
		else{
			$idpersona=$_SESSION['idpersona'];
		}

		$sql="SELECT * FROM yoficiosp where idoficio='$id' and idpersturna='$aperson'";
		$data = $this->general($sql);
		if(count($data)>0){
			$x.="No se puede turnar, ya ha sido turnado a esta persona";
		}
		else{

			$sql="SELECT * FROM yoficiosp where idoficio='$id' and (idpersturna='".$_SESSION['idpersona']."')";
			$xof = $this->general($sql);
			if(count($xof)==0){

				$sql="SELECT * FROM yoficiosp where idoficio='$id' and (idpersturna='".$_SESSION['superior']."')";
				$xof = $this->general($sql);

			}
			if(count($xof)==0){
				$x.="No se puede turnar";
			}
			else{
				$arreglo =array();
				$arreglo+=array('fechturnado'=>$horaturn);
				$arreglo+=array('idpersturna'=>$aperson);
				$arreglo+=array('idoficio'=>$id);
				$arreglo+=array('idofp'=>$xof['0']['idoficiop']);
				$arreglo+=array('observacionest'=>$observa2);
				$arreglo+=array('leido'=>0);
				$arreglo+=array('estado'=>0);

				$this->insert('yoficiosp', $arreglo);

				$arreglo =array();
				$arreglo+=array('contesto'=>1);
				$arreglo+=array('fcontesta'=>$horaturn);
				$arreglo+=array('contesta'=>$observa2);
				$arreglo+=array('observacionest'=>"Turnado");
				$this->update('yoficiosp',array('idoficiop'=>$xof['0']['idoficiop']), $arreglo);
				$x.=$id;
			}
		}
		return $x;
	}
	public function borraturno(){
		if (isset($_REQUEST['id'])){$idoficiop=$_REQUEST['id'];}
		$a=$this->borrar('yoficiosp','idoficiop',$idoficiop);
		return $a;
	}
	public function borrarespuesta(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		$arreglo =array();
		$arreglo+=array('contesto'=>0);
		$arreglo+=array('contesta'=>"");
		$x=$this->update('yoficiosp',array('idoficiop'=>$id), $arreglo);
		return $x;
	}
	public function responder(){
		$x="";
		$hora="12:00:00";
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		if (isset($_REQUEST['respuesta'])){$respuesta=$_REQUEST['respuesta'];}
		if (isset($_REQUEST['idcontestado'])){$idcontestado=$_REQUEST['idcontestado'];}
		if (isset($_REQUEST['horaresp'])){
			$hora=$_REQUEST['horaresp'];
		}
		if (isset($_REQUEST['fecharesp'])){
			$fx=explode("-",$_REQUEST['fecharesp']);
			$fecharesp=$fx['2']."-".$fx['1']."-".$fx['0']." ".$hora;
		}
		$arreglo =array();
		$arreglo+=array('contesta'=>$respuesta);
		$arreglo+=array('contesto'=>1);
		$arreglo+=array('fcontesta'=>$fecharesp);

		$x.=$this->update('yoficiosp',array('idoficio'=>$id,'idpersturna'=>$idcontestado), $arreglo);

		return $x;
	}
	public function agregaroficio(){
		$x="";
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		if (isset($_REQUEST['idresp'])){$idresp=$_REQUEST['idresp'];}

		$sql="SELECT * FROM yoficiosze_archivos left outer join yoficiosze on yoficiosze.idoficio=yoficiosze_archivos.idoficio where yoficiosze_archivos.idoficio='$idresp'";
		$a=$this->general($sql);
		for($i=0;$i<count($a);$i++){
			$arreglo =array();
			$arreglo+=array('idoficio'=>$id);
			$arreglo+=array('idoficioresp'=>$idresp);
			$arreglo+=array('tipo'=>1);
			$arreglo+=array('direccion'=>$a[$i]['direccion']);
			$arreglo+=array('anio'=>$a[$i]['anio']);
			$idoficio=$this->insert('yoficios_archivosresp', $arreglo);
		}

		$sql="SELECT * FROM yoficiosze_archivosresp left outer join yoficiosze on yoficiosze.idoficio=yoficiosze_archivosresp.idoficio where yoficiosze_archivosresp.idoficio='$idresp'";
		$a=$this->general($sql);
		for($i=0;$i<count($a);$i++){
			$arreglo =array();
			$arreglo+=array('idoficio'=>$id);
			$arreglo+=array('idoficioresp'=>$idresp);
			$arreglo+=array('tipo'=>1);
			$arreglo+=array('direccion'=>$a[$i]['direccion']);
			$arreglo+=array('anio'=>$a[$i]['anio']);
			$idoficio=$this->insert('yoficios_archivosresp', $arreglo);
		}
		return $sql;
	}
	public function firma_entrega(){
		$x="";
		$fecha=date("Y-m-d H:i:s");
		$tipof=$_REQUEST['tipof'];

		if (isset($_REQUEST['par_firma'])){
			$par_firma=$_REQUEST['par_firma'];
		}
		if($tipof=="recepcion"){
			$idturnado=$_SESSION['idpersona'];
			$idpersona=$_SESSION['idpersona'];
			$sql="select * from personal where idpersona='".$_SESSION['idpersona']."'";
		}
		else{
			$idturnado=$_REQUEST['idturnado'];
			$idpersona=$_REQUEST['idpersona'];
			$contra=$_REQUEST['contra'];
			$pass=md5(trim($contra));
			$sql="select * from personal where idpersona='$idpersona' and pass='$pass'";
		}

		$resp=$this->general($sql);
		$acceso=count($resp);
		if($acceso==1){
			if($tipof=="recepcion"){
				$pass=$resp[0]['pass'];
			}

			foreach($par_firma as $v2){
				$firma=md5($pass." ".$fecha." ".$v2);
				$sql="select * from yoficiosp where idoficio='$v2' and idpersturna='$idturnado'";
				$prefirma=$this->general($sql);
				if(count($prefirma)>0){
					$this->update('yoficiosp',array('idoficio'=>$v2,'idpersturna'=>$idturnado), array('firma'=>$firma,"idrecibido"=>$idpersona,"frecibido"=>$fecha,"estado"=>1));
				}
				else{
					$this->update('yoficiosp',array('idoficio'=>$v2,'idpersturna'=>$_SESSION['superior']), array('firma'=>$firma,"idrecibido"=>$idpersona,"frecibido"=>$fecha,"estado"=>1));
				}
			}
		}
		else{
			$x="Contraseña incorrecta";
		}
		return "$x";
	}
	public function duplicado(){
		$x="";

		if (isset($_REQUEST['numero'])){$numero=$_REQUEST['numero'];}
		if (isset($_REQUEST['numoficio'])){$numoficio=$_REQUEST['numoficio'];}
		if (isset($_REQUEST['fechaofi'])){$fechaofi=date("Y-m-d",strtotime($_REQUEST['fechaofi']));}

		$nuevafecha = strtotime ( '-2 month' , strtotime ( $fechaofi ) ) ;
		$fecha1 = date ( "Y-m-d" , $nuevafecha )." 00:00:00";
		$fechaofi.=" 23:59:59";
		$sql="SELECT idoficio, numero, numoficio, fechaofi, asunto, remitente  from yoficios where idcentro='".$_SESSION['idcentro']."' and (numoficio like '%$numoficio%') and year>='".$_SESSION['anio']."' limit 10";
		$resp=$this->general($sql);
		$x.="<div class='row container'>";
			$x.="<div class='col-10'>";
			$x.= "Lista de oficios similares a: $numoficio ";
			$x.="</div>";
			$x.="<div class='col-2'>";
				$x.="<button class='btn btn-outline-secondary btn-sm' onclick='$(\"#duplicado\").hide();' type='button'><i class='fas fa-sign-out-alt'/>Cerrar</button>";
			$x.="</div>";
			$x.="<div class='col-12'>";
			$x.="<table class='table table-sm' style='font-size:13px'>";
			$x.="<thead><tr><th>-</th><th>#Numero</th><th>Oficio</th><th>Fecha</th><th>Asunto</th><th>Remitente</th></tr></thead>";
			for($i=0;$i<count($resp);$i++){
				$x.="<tr id=".$resp[$i]['idoficio']." class='edit-t'>";
				$x.="<td>";
				$x.= "<button class='btn btn-outline-secondary btn-fill pull-left btn-sm' id='edit_corresp' title='Editar' data-lugar='a_corresp/editar' type='button'><i class='fas fa-pencil-alt'></i></button>";
				$x.="</td>";
				$x.="<td >";
				$x.=$resp[$i]['numero'];
				$x.="</td>";
				$x.="<td bgcolor='silver'>";
				$x.=$resp[$i]['numoficio'];
				$x.="</td>";
				$x.="<td>";
				$x.=fecha($resp[$i]['fechaofi']);
				$x.="</td>";
				$x.="<td>";
				$x.=$resp[$i]['asunto'];
				$x.="</td>";
				$x.="<td>";
				$x.=$resp[$i]['remitente'];
				$x.="</td>";
				$x.="</tr>";
			}
			$x.="</table>";
			$x.="<button class='btn btn-outline-secondary btn-sm' onclick='$(\"#duplicado\").hide();' type='button'><i class='fas fa-sign-out-alt'/>Cerrar</button>";
			$x.="</div>";
		$x.="</div>";
		return $x;
	}
	public function remitente_buscar(){
		$x="";
		if (isset($_REQUEST['valor'])){$valor=$_REQUEST['valor'];}

		$fecha=date("d-m-Y");
		$nuevafecha = strtotime ( '-6 month' , strtotime ( $fecha ) ) ;
		$fecha1 = date ( "Y-m-d" , $nuevafecha );

		$sql="SELECT DISTINCT remitente, cargo, dependencia from yoficios where idcentro='".$_SESSION['idcentro']."' and (remitente like '%$valor%') and fechaofi>='$fecha1' order by idoficio desc limit 5";
		$resp=$this->general($sql);
		$x.="<div class='row container'>";
			$x.="<div class='col-10'>";
			$x.= "Remitentes ";
			$x.="</div>";
			$x.="<div class='col-2'>";
				$x.="<button class='btn btn-outline-secondary btn-sm' onclick='$(\"#remitente_sug\").hide();' type='button'><i class='fas fa-sign-out-alt'/>Cerrar</button>";
			$x.="</div>";
			$x.="<div class='col-12'>";
				$x.="<table class='table table-sm' style='font-size:13px' id='remitentetb'>";
				$x.="<thead><tr><th>Remitente</th><th>Cargo</th><th>Dependencia</th></tr></thead>";
				for($i=0;$i<count($resp);$i++){
					$x.="<tr id=".$resp[$i]['remitente']." class='edit-t' >";
					$x.="<td >";
					$x.=trim($resp[$i]['remitente']);
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
				$x.="<button class='btn btn-outline-secondary btn-sm' onclick='$(\"#remitente_sug\").hide();' type='button'><i class='fas fa-sign-out-alt'/>Cerrar</button>";
			$x.="</div>";
		$x.="</div>";
		return $x;
	}
	public function busca_salida(){
		$x="";
		if (isset($_REQUEST['texto'])){
			$texto=$_REQUEST['texto'];
		}
		$sql="SELECT yoficiosze.*,personal.nombre as elabora FROM yoficiosze left outer join personal on personal.idpersona=yoficiosze.idelabora
		where (yoficiosze.numero like '%$texto%') and documento!='comision' order by yoficiosze.idoficio desc";
		$resp=$this->general($sql);

		$x.="<table class='table table-sm' style='font-size:13px' id='remitentetb'>";
		$x.="<thead><tr><th>-</th><th>Número</th><th>Fecha</th><th>Destinatario</th><th>Asunto</th<th>Documento</th></tr></thead>";
		for($i=0;$i<count($resp);$i++){
			$x.="<tr id=".$resp[$i]['idoficio']." class='edit-t' >";
			$x.="<td >";
			$x.="<button class='btn btn-outline-secondary btn-sm' id='agregar_corresp' title='Editar' data-lugar='a_corresps/editar' type='button'><i class='fas fa-pencil-alt'></i></i></button>";
			$x.="</td>";

			$x.="<td >";
			$x.=trim($resp[$i]['numero']);
			$x.="</td>";
			$x.="<td >";
			$x.=fecha($resp[$i]['fecha']);
			$x.="</td>";

			$x.="<td >";
			$x.=trim($resp[$i]['destinatario']);
			$x.="</td>";

			$x.="<td >";
			$x.=trim($resp[$i]['asunto']);
			$x.="</td>";

			$x.="<td >";
			$x.=trim($resp[$i]['documento']);
			$x.="</td>";

			$x.="</tr>";
		}
		$x.="</table>";
		return $x;
	}
	public function solicita_turno(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		$sql="SELECT * FROM yoficios_solicitud where idpersona='".$_SESSION['idpersona']."' and idoficio='$id'";
		$stmt= $this->dbh->query($sql);
		if($stmt->rowCount()==0){


			$arreglo=array();
			$arreglo+=array('idpersona'=>$_SESSION['idpersona']);
			$arreglo+=array('fecha'=>date("Y-m-d H:i:s"));
			$arreglo+=array('idoficio'=>$id);
			$arreglo+=array('estado'=>0);
			$x=$this->insert('yoficios_solicitud', $arreglo);
			return $x;
		}
		else{
			return "Ya fue solicitado anteriormente";
		}
	}
	public function solicitudes(){
		try{
			parent::set_names();

			$sql="select yoficios_solicitud.fecha, yoficios_solicitud.idoficio, personal.nombre, yoficios.numero FROM yoficios_solicitud left outer join yoficios on yoficios.idoficio=yoficios_solicitud.idoficio	left outer join personal on personal.idpersona=yoficios_solicitud.idpersona	where yoficios_solicitud.estado=0";
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

			$sql="select * FROM yoficios_solicitud where estado=0 and idoficio='$idoficio'";
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

		$sql="SELECT * FROM yoficios_solicitud where id='$idrel'";
		$stmt= $this->dbh->query($sql);
		if($stmt->rowCount()>0){
			$row =$stmt->fetchObject();

			$sql="SELECT * FROM yoficiosp where idoficio='$id' limit 1";
			$turno= $this->dbh->query($sql);
			$row1 =$turno->fetchObject();

			$arreglo =array();
			$arreglo+=array('fechturnado'=>date("Y-m-d H:i:s"));
			$arreglo+=array('idoficio'=>$id);
			$arreglo+=array('observacionest'=>"");
			$arreglo+=array('leido'=>0);
			$arreglo+=array('estado'=>0);

			$arreglo+=array('idpersturna'=>$row->idpersona);
			$arreglo+=array('idofp'=>$row1->idoficiop);
			$x=$this->insert('yoficiosp', $arreglo);

			$arreglo =array();
			$arreglo+=array('estado'=>1);
			$this->update('yoficios_solicitud',array('id'=>$idrel), $arreglo);
			return $x;
		}

	}
	public function cancelasol(){
		if (isset($_REQUEST['idrel'])){$idrel=$_REQUEST['idrel'];}
		$a=$this->borrar('yoficios_solicitud','id',$idrel);
		return $a;
	}
	public function c_buscarsalida($texto){
		try{
			parent::set_names();

			if($this->nivel_personal==0){
				$sql="SELECT * FROM yoficiosze where (destinatario LIKE '%$texto%') or (asunto LIKE '%$texto%') or (numero LIKE '%$texto%') order by yoficiosze.idoficio desc limit 100";
			}
			else if($this->nivel_personal==7){
				$sql="SELECT * FROM yoficiosze left outer join yoficioszep on yoficioszep.idoficio=yoficiosze.idoficio WHERE (destinatario LIKE '%$texto%' or asunto LIKE '%$texto%' or numero LIKE '%$texto%') and ( yoficioszep.idpersturna = ".$_SESSION['idpersona']." or yoficioszep.idpersturna = ".$_SESSION['superior'].") and yoficioszep.estado=1 GROUP BY yoficiosze.IDOFICIO order by yoficiosze.idoficio desc limit 100";
			}
			else{
				$sql="SELECT * FROM yoficiosze left outer join yoficioszep on yoficioszep.idoficio=yoficiosze.idoficio WHERE (destinatario LIKE '%$texto%' or asunto LIKE '%$texto%' or numero LIKE '%$texto%') and ( yoficioszep.idpersturna = ".$_SESSION['idpersona'].") and yoficioszep.estado=1 GROUP BY yoficiosze.IDOFICIO order by yoficiosze.idoficio desc  limit 100";
			}
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED! $sql".$e->getMessage();
		}
	}

	public function c_oficio_resp($id){
		try{
			parent::set_names();
			$sql="SELECT * FROM yoficiosze where idoficio='$id'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetch();
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function c_archivos_resp($id){
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
	public function c_acuse_resp($id){
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
	public function escanear(){
		$id=$_REQUEST['id'];
		$arreglo =array();
		$arreglo+=array('escanear'=>1);
		$arreglo+=array('idperscan'=>$_SESSION['idpersona']);
		$x=$this->update('yoficios',array('idoficio'=>$id), $arreglo);
		return $x;
	}
	public function pendientes_cmb(){
		$x="";
		try{
			$c_entrada = json_decode($this->c_entrada(),true);
			$x="<select name='idoficio' id='idoficio' class='form-control' style='width:250px !important' onchange='idoficio(this)'>";
			$x.="<option disabled selected>Seleccione un oficio</option>";
			foreach($c_entrada as $key){
				$x.= "<option value=".$key['idoficio'];
				if ($key['contestado']==0){
						$x.= " style='background-color: gold;'";
				}
				if($_SESSION['tmp']==$key['idoficio']) {
					$x.=" selected";
				}
				$x.= ">".$key['numero']." : " .$key['remitente']."</option>";
			}
			$x.= "</select>";
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
		return $x;
	}
	public function reporte(){
		$de=explode("-",$_REQUEST['desde']);
		$desde=$de['2']."-".$de['1']."-".$de['0']." 00:00:00";

		$ha=explode("-",$_REQUEST['hasta']);
		$hasta=$ha['2']."-".$ha['1']."-".$ha['0']." 23:59:59";
		try{
			$sql="SELECT
				yoficios.idcentro,
				yoficios.idoficio,
				yoficios.numero,
				yoficios.numoficio,
				yoficios.remitente,
				yoficios.dependencia,
				personal.nombre,
				area.area,
				yoficios.frecibido,
				yoficios.fcaptura,
				yoficios.modificado,
				yoficiosp.fechturnado,
				yoficiosp.frecibido as f_irma,
				yoficiosp.fcontesta
			FROM
				yoficiosp
			LEFT OUTER JOIN yoficios ON yoficios.idoficio = yoficiosp.idoficio
			LEFT OUTER JOIN personal ON personal.idpersona = yoficiosp.idpersturna
			LEFT OUTER JOIN area ON area.idarea = personal.idarea
			WHERE
				yoficios.fechaofi between '$desde' and '$hasta'
			AND yoficios.idcentro = 1 order by yoficios.idoficio asc, yoficiosp.idoficiop asc";
			//echo $sql;
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function firmar_unico(){
		$id=$_REQUEST['id'];
		$idturnado=$_SESSION['idpersona'];
		$idpersona=$_SESSION['idpersona'];
		$x="";
		$sql="select * from personal where idpersona='".$_SESSION['idpersona']."'";
		$resp=$this->general($sql);
		$pass=$resp[0]['pass'];
		$fecha=date("Y-m-d H:i:s");
		$firma=md5($pass." ".$fecha." ".$id);

		$sql="select * from yoficiosp where idoficio='$id' and idpersturna='$idturnado'";
		$prefirma=$this->general($sql);
		if(count($prefirma)>0){
			$x=$this->update('yoficiosp',array('idoficio'=>$id,'idpersturna'=>$idturnado), array('firma'=>$firma,"idrecibido"=>$idpersona,"frecibido"=>$fecha,"estado"=>1));
		}
		else{
			$x=$this->update('yoficiosp',array('idoficio'=>$id,'idpersturna'=>$_SESSION['superior']), array('firma'=>$firma,"idrecibido"=>$idpersona,"frecibido"=>$fecha,"estado"=>1));
		}
		return $x;
	}

	public function reporte2(){
		$sql="SELECT personal.idpersona, personal.nombre, count(idpersturna) as total FROM YOFICIOSP
		left outer join personal on personal.idpersona=yoficiosp.idpersturna WHERE  CONTESTO=0 GROUP BY IDPERSTURNA order by total desc";
		$response=$this->general($sql);
		$arreglo=array();
		for($i=0;$i<count($response);$i++){
			$arreglo[$i]=array('idpersona'=>$response[$i]['idpersona'], 'nombre'=>$response[$i]['nombre'], 'total'=>$response[$i]['total']);
		}
		return $arreglo;
	}
}

	$db = new Corresp();
	if(strlen($function)>0){
		echo $db->$function();
	}

?>
