<?php
  require_once("db_.php");
  $id=$_REQUEST['id'];
  $result = $db->c_oficio($id);
	$c_archivos = $db->c_archivos($id);

  if ($db->nivel_captura==1){
  	$tipo=0;
  }
  else{
  	$tipo=1;
  	$lectura="disabled";
  }
  if (isset($_REQUEST['id2'])){
  	$tipo=$_REQUEST['id2'];
  }

  for($fil=0;$fil<count($c_archivos);$fil++){
    echo "<div style='border:.1px solid silver;float:left;margin:10px'>";

    echo "<a href='".$db->doc.$result['year']."/".$c_archivos[$fil]['direccion']."' data-caption='Correspondencia' target='nuevo'>";
    echo "<img src='".$db->doc.$result['year']."/".$c_archivos[$fil]['direccion']."' alt='Correspondencia'>";
    echo "</a><br>";

    if ($db->nivel_captura==1 and $tipo==0){
      echo "<button class='btn btn-outline-secondary btn-sm' title='Eliminar archivo'
      id='delfile_orden'
      data-ruta='".$db->doc.$result['year']."/".$c_archivos[$fil]['direccion']."'
      data-keyt='idfile'
      data-key='".$c_archivos[$fil]['idfile']."'
      data-tabla='yoficios_archivos'
      data-campo='file_asistencia'
      data-tipo='2'
      data-iddest='$id'
      data-divdest='trabajo'
      data-borrafile='1'
      data-dest='a_corresp/editar.php?id='
      ><i class='far fa-trash-alt'></i></button>";
    }
    echo "</div>";
  }
 ?>
 <script type="text/javascript">
 	$(function() {
 		baguetteBox.run('.baguetteBoxOne');
 	});
 </script>
