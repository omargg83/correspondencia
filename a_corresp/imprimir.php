<?php
	require_once("db_.php");
	$id=$_REQUEST['id'];
	$tipo=$_REQUEST['tipo'];

	if($tipo==1){
		error_reporting(E_ALL);
		set_include_path('../librerias15/pdf2/src/'.PATH_SEPARATOR.get_include_path());

		include 'Cezpdf.php';

		$pdf = new Cezpdf('letter','portrait','color',array(255,255,255));
		$pdf->selectFont('Helvetica');

		$result = $db->c_oficio($id);

		$pdf->addJpegFromFile("../img/ssh.jpg",20,728,70);
		$pdf->addJpegFromFile("../img/gobierno.jpg",90,740,85);
		$pdf->addJpegFromFile("../img/escudo.jpg",528,725,70);


		$pdf->addText(185,750,12,"SUBDIRECCIÓN GENERAL DE SERVICIOS DE SALUD PUBLICA",0,'left');
		$pdf->addText(185,735,8,"HOJA DE CONTROL",0,'left');
		$fuente=10;

		$pdf->addText(20,700,$fuente,"<b>FOLIO INTERNO:</b>",0,'left');
		$pdf->addText(20,690,$fuente,$result['numero'],0,'left');

		$pdf->addText(130,700,$fuente,"<b>NO. DE OFICIO:</b>",0,'left');
		$pdf->addText(130,690,$fuente,$result['numoficio'],0,'left');

		$pdf->addText(330,700,$fuente,"<b>FECHA DEL OFICIO:</b>",0,'left');
		$f=explode("-",$result['fechaofi']);
		$pdf->addText(330,690,$fuente,$f[2]."-".$f[1]."-".$f[0],0,'left');

		$pdf->addText(460,700,$fuente,"<b>FOLIO DE JEFATURA:</b>",0,'left');
		$pdf->addText(460,690,$fuente,$result['folio'],0,'left');

		$pdf->addText(20,670,$fuente,"<b>ASUNTO:</b>",0,'left');
		$a=$pdf->addText(20,660,$fuente,$result['asunto'],560,'full',0,0);
		$a=$pdf->addText(20,650,$fuente,$a,415,'full',0,0);
		$a=$pdf->addText(20,640,$fuente,$a,415,'full',0,0);

		$pdf->addText(20,610,$fuente,"<b>REMITENTE:</b>",0,'left');
		$pdf->addText(20,600,$fuente,$result['remitente'],0,'left');

		$pdf->addText(20,580,$fuente,"<b>CARGO:</b>",0,'left');
		$pdf->addText(20,570,$fuente,$result['cargo'],0,'left');

		$pdf->addText(20,550,$fuente,"<b>OBSERVACIONES:</b>",0,'left');
		$pdf->addText(20,540,$fuente,$result['anexos'],0,'left');


		$pdf->rectangle(20,520,10,10);
		$pdf->addText(32,521,$fuente-2,"<b>URGENTE</b>",0,'left');

		$pdf->rectangle(90,520,10,10);
		$pdf->addText(102,521,$fuente-2,"<b>PARA SU ATENCIÓN</b>",0,'left');

		$pdf->rectangle(200,520,10,10);
		$pdf->addText(212,521,$fuente-2,"<b>PARA SU CONOCIMIENTO</b>",0,'left');

		$pdf->rectangle(330,520,10,10);
		$pdf->addText(342,521,$fuente-2,"<b>ACUERDO</b>",0,'left');

		$pdf->rectangle(400,520,10,10);
		$pdf->addText(412,521,$fuente-2,"<b>CONTESTAR POR OFICIO</b>",0,'left');

		$pdf->rectangle(530,520,10,10);
		$pdf->addText(542,521,$fuente-2,"<b>ARCHIVAR</b>",0,'left');

		$pdf->addText(20,500,$fuente,"<b>COMENTARIOS:</b>",0,'left');

		$sql="select * from personal where idpersona='".$_SESSION['idpersona']."'";
		$recibe=$db->general($sql);
		$f=explode("-",substr($result['frecibido'],0,10));
		$pdf->addText(20,440,$fuente-2,$f[2]."-".$f[1]."-".$f[0]." ".$recibe[0]['nombre'],0,'left');
		$pdf->addText(20,430,$fuente-2,"<b>CAPTURÓ:</b>",0,'left');

		/*
			$sql="select * from personal where idpersona='".$result['recibido']."'";
			$capturo=$db->general($sql);
			$f=explode("-",substr($result['fcaptura'],0,10));
			$pdf->addText(350,440,$fuente-2,$f[2]."-".$f[1]."-".$f[0]." ".$capturo[0]['nombre'],0,'left');
			$pdf->addText(350,430,$fuente-2,"<b>RECIBIÓ:</b>",0,'left');
		*/
		$pdf->ezStream();

	}




?>
