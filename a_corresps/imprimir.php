<?php
	require_once("db_.php");
	$idcomision=$_REQUEST['id'];
	$tipo=$_REQUEST['tipo'];
	$valor=$_REQUEST['valor'];

	$sql="SELECT numero,(select count(direccion) from yoficiosze_archivos where yoficiosze_archivos.idoficio=yoficiosze.idoficio) as oficio,fecha,documento,concat(destinatario,' ',cargo,' ',dependencia) as destinatario,asunto FROM yoficiosze where idoficio in ($valor)";
	$row=$db->general($sql);

	if($tipo==1){
		/////////////////////////////////////////////////////////////
		set_include_path('../librerias15/pdf2/src/'.PATH_SEPARATOR.get_include_path());
		include 'Cezpdf.php';
		$pdf = new Cezpdf('letter','landscape','color',array(255,255,255));
		$pdf->selectFont('Helvetica');
		$pdf->addJpegFromFile("../img/ssh.jpg",40,550,70);
		$pdf->addJpegFromFile("../img/gobierno.jpg",375,560,90);
		$pdf->addJpegFromFile("../img/escudo.jpg",690,550,70);

		$pdf->addText(0,540,9,"<b>CONTROL DE CORRESPONDENCIA</b>",810,'center');
		$pdf->ezText('',50);
		$arre=0;
		///////////////////////////////////////////////
		$contar=0;
		$contador=1;
		for($i=0;$i<count($row);$i++){
			$data[$contar]=array(
				'col1'=>$row[$i]['numero'],
				'col2'=>$row[$i]['oficio'],
				'col3'=>fecha($row[$i]['fecha']),
				'col4'=>$row[$i]['documento'],
				'col5'=>$row[$i]['destinatario'],
				'col6'=>$row[$i]['asunto'],
				'col7'=>"",
				'col8'=>"",
				'col9'=>""
			);
			$contador++;
			$contar++;
		}

		$cols = array(
			'col1'=>'Numero',
			'col2'=>'Oficio',
			'col3'=>'Fecha',
			'col4'=>'Documento',
			'col5'=>'Destinatario',
			'col6'=>'Asunto',
			'col7'=>'Mensajeria',
			'col8'=>'Acuse',
			'col9'=>'Area');

		$pdf->ezTable($data,$cols,"",array('shadeHeadingCol'=>array(0.8,0.8,0.8),'shaded'=>0,'gridlines'=>31,'xPos'=>'left','xOrientation'=>'right','width'=>600,'cols'=>array(
						'col1'=>array('width'=>50),
						'col2'=>array('width'=>35),
						'col3'=>array('width'=>60),
						'col4'=>array('width'=>60),
						'col5'=>array('width'=>160),
						'col6'=>array('width'=>160),
						'col7'=>array('width'=>70),
						'col8'=>array('width'=>70),
						'col9'=>array('width'=>70)
						),'fontSize' => 8));
		$pdf->ezStream();


	}

?>
