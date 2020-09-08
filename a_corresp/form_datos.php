<?php
  require_once("db_.php");
	$id=$_REQUEST['id'];

  $sql="SELECT * FROM yoficiosp where idoficiop=$id";
  $row = $db->general($sql);
?>
<div class='modal-header'>
	<h5 class='modal-title'>Información</h5>
</div>
  <div class='modal-body' >

    <?php
      echo "<div class='row'>";
        echo "<div class='col-4'>";
          echo "<b>Fecha en que le fue turnado:</b>";
        echo "</div>";
        echo "<div class='col-8'>";
          echo fecha($row[0]['fechturnado'],2);
        echo "</div>";
      echo "</div>";

      echo "<div class='row'>";
        echo "<div class='col-4'>";
          echo "<b>Fecha de firma:</b>";
        echo "</div>";
        echo "<div class='col-8'>";
          if(strlen($row[0]['frecibido'])>0){
            echo fecha($row[0]['frecibido'],2);
          }
        echo "</div>";
      echo "</div>";

      echo "<div class='row'>";
        echo "<div class='col-4'>";
          echo "<b>Firma digital:</b>";
        echo "</div>";
        echo "<div class='col-8'>";
          if(strlen($row[0]['firma'])>0){
            echo $row[0]['firma'];
            $per=$db->personal_edit($row[0]['idrecibido']);
            echo "<br>".$per['nombre'];
          }
          else{
            echo "Sin firma en sistema";
          }
        echo "</div>";
      echo "</div>";

      echo "<hr>";

      if(strlen($row[0]['fcontesta'])>0){
        echo "<div class='row'>";
          echo "<div class='col-4'>";
          echo "<b>Fecha de respuesta:</b>";
          echo "</div>";
          echo "<div class='col-8'>";
            echo fecha($row[0]['fcontesta'],2);
          echo "</div>";
        echo "</div>";

        
        echo "<div class='row'>";
          echo "<div class='col-4'>";
            echo "<b>Respuesta:</b>";
          echo "</div>";
          echo "<div class='col-8'>";
            echo $row[0]['observacionest']." / ".$row[0]['contesta'];
          echo "</div>";
        echo "</div>";


      }
      else{
        echo "<div class='row'>";
          echo "<div class='col-4'>";
            echo "Respuesta pendiente";
          echo "</div>";
        echo "</div>";
      }
     ?>

  </div>
  <div class="modal-footer">
		<div class='btn-group'>
		<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal" title='Cancelar'><i class="fas fa-sign-out-alt"></i>Cerrar</button>
		</div>
	</div>
