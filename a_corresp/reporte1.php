<?php
  require_once("db_.php");
  $fecha=date("d-m-Y");
  $nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
  $fecha1 = date ( "d-m-Y" , $nuevafecha );
?>

<form id='consulta_avanzada' action='' data-destino='a_corresp/reporte1_resultado' data-div='resultado'  autocomplete='off'>
  <div class='container' >
    <div class="alert alert-success" role="alert">
      <h4 class="alert-heading">Analisis</h4>
      <div class='row'>
        <div class='col-sm-3'>
            <label>Del</label>
            <input class="form-control fechaclass" placeholder="Desde...." type="text" id='desde' name='desde' value='<?php echo $fecha1; ?>' autocomplete="off">
        </div>

        <div class='col-sm-3'>
          <label>Al</label>
          <input class="form-control fechaclass" placeholder="Hasta...." type="text" id='hasta' name='hasta' value='<?php echo $fecha; ?>' autocomplete="off">
        </div>

      </div>
      <hr>
      <div class='row'>
        <div class='col-sm-4'>
          <div class='btn-group'>
            <button title='Buscar' class='btn btn-outline-warning btn-sm' id='buscar_canalizado' type='submit' id='lista_buscar'><i class='fa fa-search'></i><span> Buscar</span></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<div id='resultado'>

</div>

<script>
$(function() {
  fechas();
  var desde= $("#desde").val();
  var hasta= $("#hasta").val();
  var estado= $("#estado").val();
  $("#resultado").load("a_polizas/cemitidas_lista.php?desde="+desde+"&hasta="+hasta+"&estado="+estado);
});
</script>
