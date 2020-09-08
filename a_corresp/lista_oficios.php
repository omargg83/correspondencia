<?php
require_once("db_.php");
$valor=$_REQUEST['valor'];
$id=$_REQUEST['id'];
$row=$db->c_buscarsalida($valor);
echo "<table class='table'>";
echo "<tr><th>#</th><th>Número</th><th>Fecha</th><th>Destinatario/Asunto</th></tr>";

foreach($row as $key){
  echo "<tr id=".$key['idoficio']." class='edit-t'>";
  echo "<td>";
  echo "<button class='btn btn-outline-secondary btn-sm' id='edit_corresp' title='Editar' data-lugar='a_corresp/acuse' data-div='resultadosx'><i class='fas fa-pencil-alt'></i></button>";
  echo "</td>";
  echo "<td>";
  echo $key['numero'];
  echo "</td>";

	echo "<td>".fecha($key['fecha'])."</td>";

  echo "<td>";
  echo "<b>-".$key['destinatario']."</b><br>";
  echo $key['asunto'];
  echo "</td>";
  echo "</tr>";
}
echo "</table>";

 ?>
