<?php
	require_once("db_.php");
	$idcomision=$_REQUEST['id'];
	$tipo=$_REQUEST['tipo'];
	$valor=$_REQUEST['valor'];

	$sql="SELECT area.idarea, personal.nombre, personal.idplaza, personal.idprogra, personal.fingreso, personal.estudio, personal.rfc, personal.clave, personal.nombra, personal_orga.cargo, personal.concepto07, personal.sueldo, personal.calle, personal.colonia, personal.municipio, personal.telefono, personal.telcel, personal.numero, personal.categoria, area.area, personal_especialidad.especialidad FROM personal
			left outer join area on area.idarea=personal.idarea
			left outer join personal_orga on personal_orga.id=personal.idcargo
			left outer join personal_especialidad on personal_especialidad.idespecialidad=personal.idespecialidad
			where personal.idarea in ($valor) order by area.orden,personal_orga.orden,personal.idpersona";
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

		$pdf->addText(0,540,9,"<b>PLANTILLA DE PERSONAL</b>",810,'center');
		$pdf->ezText('',50);
		$pdf->ezText('',10);
		$arre=0;
		///////////////////////////////////////////////
		$contar=0;
		$contador=1;
		for($i=0;$i<count($row);$i++){
			if($row[$i]['idarea']!=$arre){

				$pdf->ezText('',10);
				$pdf->ezTable($data,"","",array('xPos'=>'left','xOrientation'=>'right','cols'=>array(
						'No.'=>array('width'=>20),
						'Estudio'=>array('width'=>50),
						'Nombre'=>array('width'=>180),
						'RFC'=>array('width'=>80),
						'C. Presupuestal'=>array('width'=>160),
						'Cargo'=>array('width'=>260)
						),'fontSize' => 8));
						$data=array();
						$contar=0;
						$arre=$row[$i]['idarea'];
			}

			$data[$contar]=array(
				'NO.'=>$contador,
				'Estudio'=>$row[$i]['estudio'],
				'Nombre'=>$row[$i]['nombre'],
				'RFC'=>$row[$i]['rfc'],
				'C. Presupuestal'=>$row[$i]['clave'],
				'Cargo'=>$row[$i]['cargo']
			);
			$contador++;
			$contar++;

		}
		$pdf->ezText('',10);
		$pdf->ezTable($data,"","",array('xPos'=>'left','xOrientation'=>'right','cols'=>array(
						'NO.'=>array('width'=>50),
						'Estudio'=>array('width'=>50),
						'Nombre'=>array('width'=>180),
						'RFC'=>array('width'=>80),
						'C. Presupuestal'=>array('width'=>160),
						'Cargo'=>array('width'=>260)
						),'fontSize' => 8));
		$pdf->ezStream();


	}

?>
