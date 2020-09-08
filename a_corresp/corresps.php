<?php
	require_once("db_.php");
	$id=$_REQUEST['id'];

?>
<div class="card">
<form id='cliente' action=''>
	<div class="card-header">Oficios de salida</div>
	<div class="card-body">
		<div clas='row'>
			<input type="text" name="cliente_bus" id='cliente_bus' placeholder='buscar oficio' class='form-control' autocomplete=off>
		</div>
	</div>
	<div class="card-footer">
		<div class='btn-group'>
			<button class='btn btn-outline-secondary btn-sm' type='submit' id='lista_cliente' data-lugar='a_corresp/lista_oficios'
			 data-valor='cliente_bus' data-function='buscar_cliente' data-div='resultadosx' id='$id'><i class='fas fa-search'></i>Buscar</button>
			<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i>Cerrar</button>
		</div>
	</div>
</form>
	<div class='container' id='resultadosx'>
	</div>
</div>
