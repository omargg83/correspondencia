<?php
	require_once("../control_db.php");
  $db = new Salud();
?>

      <div class="modal-header">
        <h5 class="modal-title">Cmabiar año</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
          echo "<div class='row'>";
            echo "<div class='col-12'>";
              echo "<label>Cambiar año</label>";
              echo "<select name='yearx_val' id='yearx_val' class='form-control'>";
                for ($i=2007;$i<=$_SESSION['hasta'];$i++){
                  if($_SESSION['anio']==$i){
                    echo "<option value='$i' selected>$i</option>";
                  }
                  else { echo "<option value='$i'>$i</option>";}
                }
              echo "</select>";
              echo "</a>";
            echo "</div>";
          echo "</div>";
        ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
