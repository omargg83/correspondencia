<?php
  require_once("db_.php");
  $fecha=date("d-m-Y");
  $nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
  $fecha1 = date ( "d-m-Y" , $nuevafecha );

  $resp=$db->reporte2();

  echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
    echo "<table class='table table-sm'>";
      foreach($resp as $key){
        echo "<tr>";
          echo "<td><b>";
            echo $key['nombre'];
          echo "</b></td>";
          echo "<td>";
            echo $key['total'];
          echo "</td>";
        echo "</tr>";

        $sql="select * from yoficiosp left outer join yoficios on yoficios.idoficio=yoficiosp.idoficio where idpersturna='".$key['idpersona']."' and contesto=0";
        $row=$db->general($sql);
        echo "<tr><td>";
        echo "<table class='table table-sm'>";
        echo "<tr><th>#interno</th><th>Oficio</th><th>Fecha</th><th>Asunto</th></tr>";
        foreach($row as $rx){
          echo "<tr  class='edit-t' id=".$rx['idoficio'].">";
            echo "<td>";
              if($_SESSION['administrador']==1){
                echo  "<button class='btn btn-outline-secondary pull-left btn-sm' id='edit_corresp".$rx['idoficio']."' title='Editar' data-lugar='a_corresp/editar'><i class='fas fa-pencil-alt'></i></button>";
              }
            echo "</td>";
            echo "<td>";
              echo $rx['numero'];
            echo "</td>";
            echo "<td>";
              echo $rx['numoficio'];
            echo "</td>";
            echo "<td>";
              echo $rx['fechaofi'];
            echo "</td>";
            echo "<td>";
              echo $rx['asunto'];
            echo "</td>";
          echo "</tr>";
        }
        echo "</table>";
        echo "</td></tr>";

      }
    echo "</table>";
  echo "</div>";

?>
