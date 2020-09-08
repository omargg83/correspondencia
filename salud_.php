<?php
if (!isset($_SESSION)) { session_start(); }
$data = json_decode(file_get_contents('php://input'), true);
$function=$data['function'];

class Salud{
  public function set_names(){
    return $this->dbh->query("SET NAMES 'utf8'");
  }

  public function __construct(){
    $this->Salud = array();
    date_default_timezone_set("America/Mexico_City");
    
    /*
    $_SESSION['mysqluser']="saludpublica";
    $_SESSION['mysqlpass']="saludp123$";
    $_SESSION['servidor'] ="172.16.0.20";
    */

    $_SESSION['mysqluser']="root";
    $_SESSION['mysqlpass']="root";
    $_SESSION['servidor'] ="localhost";
    $_SESSION['bdd']="salud";
    $this->dbh = new PDO("mysql:host=".$_SESSION['servidor'].";dbname=".$_SESSION['bdd']."", $_SESSION['mysqluser'], $_SESSION['mysqlpass']);
    echo $_SESSION['servidor'];
  }

  public function acceso(){
    global $data;
    try{
      $userPOST=htmlspecialchars($data['userAcceso']);
      $passPOST=htmlspecialchars($data['passAcceso']);
      self::set_names();

      $sql="SELECT nombre, usuario, pass, nick, estudio, idpersona, file_foto, personal.idarea, idcargo, correo, personal_orga.cargo, personal_orga.parentid, personal_orga.orden as puesto, idfondo FROM personal left outer join personal_orga on personal_orga.id=personal.idcargo where (usuario=:usuario or correo=:correo) and pass=:pass and autoriza=1";
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(":usuario",$userPOST);
      $sth->bindValue(":correo",$userPOST);
      $sth->bindValue(":pass",$passPOST);
      $sth->execute();
      $CLAVE=$sth->fetch();
      if(is_array($CLAVE)){
        if(($userPOST == $CLAVE['usuario'] or $userPOST == $CLAVE['correo']) and strtoupper($passPOST)==strtoupper($CLAVE['pass'])){
          $arr=array();
          $arr=array('acceso'=>1,'idpersona'=>$CLAVE['idpersona'],'nombre'=>$CLAVE['nombre']);
          return json_encode($arr);
        }
      }
      else{
        $arr=array();
        $arr=array('acceso'=>0,'idpersona'=>0);
        return json_encode($arr);
      }
    }
    catch(PDOException $e){
      return "Database access FAILED! ".$e->getMessage();
    }
  }
  public function afiliado(){
    global $data;
    try{
      self::set_names();
      $idfolio=$data['idfolio'];
      $sql="select * from afiliados where idfolio=:idfolio";
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(":idfolio",$idfolio);
      $sth->execute();
      return json_encode($sth->fetch(PDO::FETCH_ASSOC));
    }
    catch(PDOException $e){
      return "Database access FAILED! ".$e->getMessage();
    }
  }
/*
  /////////////////ahorro
  public function ahorro_app(){
    global $data;
    $idfolio=$data['idfolio'];

  	$anio_tmp=date("Y");
    $resp=$this->datos_ahorro($anio_tmp,$idfolio);
    $ahorro=$this->ahorro($anio_tmp,$idfolio);
    $ahorronum=count($ahorro);
    $saldofinal=$this->saldofinal($anio_tmp,$idfolio);

    if ($ahorronum==0){
      $val=number_format($saldofinal['saldofinal'],2);
    }
    else{
      $val=number_format($saldofinal['saldofinal']-$ahorro['interesx'],2);
    }
    $interes_anual=number_format($ahorro['interesx'],2);
    $arr=array();
    $cuadro=array();
    $agregar=array();

    $anio=0;
    $monto=0;
    $int_ant=0;
    foreach($resp as $key){
      if($anio!=$key['anio']){
        $anio=$key['anio'];
        $int_ant=0;
      }
      $int_ant=$int_ant+$key['montointeres'];
      $s_final=$key['saldofinal'] - $int_ant;
      $anio=$key['anio'];
      $quin_nombre=$key['quin_nombre'];
      if ($key['monto']>0){
        ////monto
        $monto="$ ".number_format($key['monto'],2);
      }
      else{
        ///retiro
        $retiro=$s_final*-1;
        $monto="$"+$retiro;
      }
      $cuadro=array("anio"=>$anio." - Q:".$quin_nombre,"monto"=>$monto);
      array_push($agregar, $cuadro);
    }

    $arr=array('disponible_anual'=>"$ ".$val,'interes_anual'=>"$ ".$interes_anual,"datos"=>$agregar);
    return json_encode($arr);
  }
  public function datos_ahorro($anio_tmp,$idfolio){
    try{
      self::set_names();
      $sql="select idfolio,anio,ahorrototal,saldofinal,saldo_anterior,monto,interes,montointeres,interestotal,
      if (retiro=1,'R',ROUND(quincena,0)) as quin_nombre,observaciones from registro where idfolio=:idfolio and anio=:anio_tmp
      order by anio,quincena,idregistro asc";
      $sth = $this->dbh->prepare($sql);

      $sth->bindValue(":idfolio",$idfolio);
      $sth->bindValue(":anio_tmp",$anio_tmp);
      $sth->execute();
      return $sth->fetchAll();
    }
    catch(PDOException $e){
      return "Database access FAILED! ".$e->getMessage();
    }
  }
  public function ahorro($anio_tmp,$idfolio){
    try{
      self::set_names();

      $sql="select sum(monto) as monto,sum(montointeres) as interesx from registro where idfolio=:idfolio and anio=:anio_tmp";
      $sth = $this->dbh->prepare($sql);

      $sth->bindValue(":idfolio",$idfolio);
      $sth->bindValue(":anio_tmp",$anio_tmp);
      $sth->execute();
      return $sth->fetch();
    }
    catch(PDOException $e){
      return "Database access FAILED! ".$e->getMessage();
    }
  }
  public function saldofinal($anio_tmp,$idfolio){
    try{
      self::set_names();
      $sql="select idfolio,anio,ahorrototal,saldofinal,saldo_anterior,monto,interes,montointeres,interestotal,if (retiro=1,'R',ROUND(quincena,0)) as quin_nombre,observaciones from registro where idfolio=:idfolio order by anio desc,quincena desc,idregistro desc";
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(":idfolio",$idfolio);
      $sth->execute();
      return $sth->fetch();
    }
    catch(PDOException $e){
      return "Database access FAILED! ".$e->getMessage();
    }
  }

  /////////////////creditos
  public function credito_app(){
    global $data;
    try{
      self::set_names();
      $filiacion=$data['filiacion'];
      $sql="select clv_cred,fecha,monto from creditos where filiacion=:filiacion";
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(":filiacion",$filiacion);
      $sth->execute();

      $arr=array();
      $arr=array('creditos'=>$sth->fetchAll(PDO::FETCH_ASSOC));
      return json_encode($arr);
    }
    catch(PDOException $e){
      return "Database access FAILED! ".$e->getMessage();
    }
  }
  public function credito_ver(){
    global $data;
    $clv_cred=$data['clvcred'];
    $filiacion=$data['filiacion'];

    $dat_credito=$this->datos_credito($clv_cred);
    $aportax=$this->aporta($clv_cred);
    $c_detalle=$this->credito_detalle($clv_cred);

    /////////////////////////////////////////////////
    $txt_estado=$dat_credito['cred_esta'];
    $txt_plazo=$dat_credito['plazo'];
    $txt_cheque=$dat_credito['nocheque'];

    $txt_monto=$dat_credito['monto'];
    $P_MONTO=$dat_credito['monto'];

    $txt_interes=$dat_credito['interes'];
    $P_INTERES=$dat_credito['interes'];

    $txt_total=$dat_credito['total'];
    $P_TOTAL=$dat_credito['total'];

    $txt_qini=$dat_credito['quin_ini']."/".$dat_credito['anio_ini'];
    $txt_qfin=$dat_credito['quin_fin']."/".$dat_credito['anio_fin'];

    $txt_credito=$dat_credito['clv_cred'];
    $txt_observaciones=$dat_credito['observa'];

    $txt_aportacion=$dat_credito['aportacion'];

    $txt_abono=$aportax['aporta'];
    $s_saldo=$dat_credito['total']-$aportax['aporta'];
    $txt_saldo=$s_saldo;

    $cuadro=array();
    $agregar=array();
    foreach($c_detalle as $key){
        $anio=$key['anio'];
        $quin_nombre=$key['quin_nombre'];
        $monto=number_format($key['monto'],2);
        $saldo=number_format($key['saldo_actual'],2);

        $cuadro=array("anio"=>$anio." - Q:".$quin_nombre,"monto"=>$monto,"saldo"=>$saldo);
        array_push($agregar, $cuadro);
    }

    $arr=array();
    $arr=array('txt_credito'=>$txt_credito, 'txt_qini'=>$txt_qini, 'txt_qfin'=>$txt_qfin, 'txt_monto'=>$txt_monto, 'txt_interes'=>$txt_interes, 'txt_total'=>$txt_total, 'txt_abono'=>number_format($txt_abono,2), 'txt_saldo'=>number_format($txt_saldo,2), 'txt_estado'=>$txt_estado, 'txt_plazo'=>$txt_plazo,"datoscred"=>$agregar);
    return json_encode($arr);

  }
  public function datos_credito($clv_cred){
    try{
      self::set_names();
      $sql="SELECT clv_cred,crx.idfolio,fecha,crx.monto,observa,crx.estado,plazo,if(crx.estado=1,'ACTIVO','INACTIVO') as cred_esta,interes,crx.total,crx.quin_ini,crx.anio_ini,crx.quin_fin,crx.anio_fin,nocheque,aportacion,(select saldo_actual from detallepago where idcredito=crx.clv_cred order by anio desc,quincena desc,iddetalle limit 1) as saldo_actual FROM creditos crx where crx.clv_cred=:clv_cred";
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(":clv_cred",$clv_cred);
      $sth->execute();
      return $sth->fetch();
    }
    catch(PDOException $e){
      return "Database access FAILED! ".$e->getMessage();
    }
  }
  public function credito_detalle($clv_cred){
    try{
      self::set_names();
      $sql="select anio,if (estado=1,'A',if(estado=6,'Inicial',if(estado=7,'Reim',ROUND(quincena,0)))) as quin_nombre,saldo_anterior,monto,saldo_actual, observaciones from detallepago where idcredito=:clv_cred order by anio,quincena,iddetalle";
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(":clv_cred",$clv_cred);
      $sth->execute();
      return $sth->fetchAll();
    }
    catch(PDOException $e){
      return "Database access FAILED! ".$e->getMessage();
    }
  }
  public function aporta($clv_cred){
    try{
      self::set_names();
      $sql="select SUM(monto) as aporta from detallepago where idcredito=:clv_cred order by anio,quincena,iddetalle";
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(":clv_cred",$clv_cred);
      $sth->execute();
      return $sth->fetch();
    }
    catch(PDOException $e){
      return "Database access FAILED! ".$e->getMessage();
    }
  }
*/
}

$db = new Salud();
if(strlen($function)>0){
  echo $db->$function();
}
?>
