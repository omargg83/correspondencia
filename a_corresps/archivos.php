<?php
require_once("db_.php");
$id=$_REQUEST['id'];

$result = $db->c_oficio($id);
$c_archivos = $db->c_archivos($id);
for($fil=0;$fil<count($c_archivos);$fil++){
  echo "<div style='border:.1px solid silver;float:left;margin:10px'>";
    echo "<a href='".$db->doc.$result['anio']."_s/".$c_archivos[$fil]['direccion']."' data-caption='Correspondencia' target='nuevo'>";
      echo "<img src='".$db->doc.$result['anio']."_s/".$c_archivos[$fil]['direccion']."' alt='Correspondencia' >";
    echo "</a><br>";

    if ($db->nivel_captura==1){
      echo "<button class='btn btn-outline-secondary btn-sm' title='Eliminar archivo'
      id='delfile_orden'
      data-ruta='".$db->doc.$result['anio']."_s/".$c_archivos[$fil]['direccion']."'
      data-keyt='idarchivo'
      data-key='".$c_archivos[$fil]['idarchivo']."'
      data-tabla='yoficiosze_archivos'
      data-campo='direccion'
      data-tipo='2'
      data-iddest='$id'
      data-divdest='trabajo'
      data-borrafile='1'
      data-dest='a_corresps/editar.php?id='
      ><i class='far fa-trash-alt'></i></button>";
    }
  echo "</div>";
}
 ?>
