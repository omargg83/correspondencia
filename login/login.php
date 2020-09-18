<?php @session_start();

	require_once("../init.php");
	class ipsi{
		public $nivel_personal;
		public $nivel_captura;

		public function __construct(){
			date_default_timezone_set("America/Mexico_City");
			try{
				$this->dbh = new PDO("mysql:host=".SERVIDOR.";dbname=".BDD, MYSQLUSER, MYSQLPASS);
				$this->dbh->query("SET NAMES 'utf8'");
			}
			catch(PDOException $e){
				return "Database access FAILED!";
			}
		}
		public function acceso(){
			try{
				if($_SERVER['REQUEST_METHOD']!="POST"){
					return 0;
				}

				$userPOST = htmlspecialchars($_REQUEST["userAcceso"]);
				$passPOST=md5($_REQUEST["passAcceso"]);

				$sql="SELECT nombre, usuario, pass, estudio, idpersona, file_foto, personal.idarea, idcargo, correo, personal_orga.cargo, personal_orga.parentid, personal_orga.orden as puesto FROM personal left outer join personal_orga on personal_orga.id=personal.idcargo where (usuario=:usuario or correo=:correo) and pass=:pass and autoriza=1";
				$sth = $this->dbh->prepare($sql);
				$sth->bindValue(":usuario",$userPOST);
				$sth->bindValue(":correo",$userPOST);
				$sth->bindValue(":pass",$passPOST);
				$sth->execute();

				if($sth->rowCount()){
					$CLAVE=$sth->fetch(PDO::FETCH_OBJ);
					if(($userPOST == $CLAVE->usuario or $userPOST == $CLAVE->correo) and strtoupper($passPOST)==strtoupper($CLAVE->pass)){
						$_SESSION['autoriza']=1;
						$_SESSION['nombre']=$CLAVE->nombre;
						$_SESSION['usuario'] = $CLAVE->usuario;
						$_SESSION['pass'] = $CLAVE->pass;
						$_SESSION['puesto']=$CLAVE->puesto;
						$_SESSION['cargo']=$CLAVE->cargo;

						$superior = $this->superior($CLAVE->parentid);
						$_SESSION['superior']=$superior->idpersona;

						$_SESSION['estudio']=$CLAVE->estudio;
						$_SESSION['idpersona']=$CLAVE->idpersona;
						$_SESSION['idarea']=$CLAVE->idarea;
						$_SESSION['foto']=$CLAVE->file_foto;
						$_SESSION['cargo']=$CLAVE->cargo;

						$fecha=date("Y-m-d");
						list($anyo,$mes,$dia) = explode("-",$fecha);
						$_SESSION['n_sistema']="Salud";

						$centro = $this->centro($CLAVE->idarea);
						$_SESSION['idcentro']=$centro->idcentro;

						$_SESSION['cfondo']="white";
						$_SESSION['anio']=date("Y");
						$_SESSION['mes']=date("m");
						$_SESSION['dia']=date("d");
						$_SESSION['nocuenta'] = 1;
						if($CLAVE->idpersona==7){
							$_SESSION['administrador']=1;
						}
						else{
							$_SESSION['administrador']=0;
						}
						$_SESSION['hasta']=2020;
						$_SESSION['foco']=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
						$_SESSION['cfondo']="white";
						$arr=array();
						$arr=array('acceso'=>1);
						return json_encode($arr);
					}
				}
				else {
					$arr=array();
					$arr=array('acceso'=>0,'idpersona'=>0);
					return json_encode($arr);
				}
				/////////////////////////////////////////////
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
		public function superior($id){
			try{
				$sql="SELECT * from personal where idcargo=:id";
				$sth = $this->dbh->prepare($sql);
				$sth->bindValue(":id",$id);
				$sth->execute();
				return $sth->fetch(PDO::FETCH_OBJ);
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
		public function centro($idarea){
			try{
				$sql="select idcentro, area from area where idarea=:id";
				$sth = $this->dbh->prepare($sql);
				$sth->bindValue(":id",$idarea);
				$sth->execute();
				return $sth->fetch(PDO::FETCH_OBJ);
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
	}
	function clean_var($val){
		$val=htmlspecialchars(strip_tags(trim($val)));
		return $val;
	}

	$db = new ipsi();
	echo $db->acceso();

?>
