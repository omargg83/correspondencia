<?php
  require_once("db_.php");
  $sol = $db->solicitudes();

  echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
  	echo "<div class='dysplay content table-responsive table-full-width' >";
  		echo "<br><h5>Solicitud de turnos</h5>";

      echo "<table class='table'>";
      echo "<thead><tr><th>-</th><th>Fecha</th><th>Numero</th><th>Solicitud</th></tr></thead>";
      foreach ($sol as $key) {
      	echo "<tr id=".$key['idoficio']." class='edit-t'>";
        echo "<td>";
        echo "<button class='btn btn-outline-secondary btn-fill pull-left btn-sm' id='edit_corresp' title='Editar' data-lugar='a_corresp/editar'><i class='fas fa-pencil-alt'></i></button>";
        echo "</td>";

        echo "<td>";
        echo fecha($key['fecha']);
        echo "</td>";

        echo "<td>";
        echo $key['numero'];
        echo "</td>";

        echo "<td>";
        echo $key['nombre'];
        echo "</td>";

        echo "</tr>";
      }
      echo "</table>";
      echo "</div>";
  echo "</div>";
?>
