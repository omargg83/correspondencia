<?php
	require_once("db_.php");
	$c_entrada = $db->c_entrada();

	echo "<nav class='navbar navbar-expand-lg navbar-light bg-light bg-danger '>
			  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
				<span class='navbar-toggler-icon'></span>
			  </button>
			  <a class='navbar-brand' ><i class='fas fa-arrow-circle-up'></i>Salida</a>
			  <div class='collapse navbar-collapse' id='navbarSupportedContent'>";
				echo "<ul class='navbar-nav mr-auto'>";
				if ($db->nivel_captura==1){
					echo"<li class='nav-item '><a class='nav-link' title='Nuevo' id='new_corresp' data-lugar='a_corresps/editar'><i class='fas fa-plus'></i><span>Nuevo</span></a></li>";
				}

				echo "<li class='nav-item' id='per_lista'>";
				echo "<select name='idoficio_salida' id='idoficio_salida' class='form-control' style='width:250px !important' onchange='oficio_ver()'>";
				echo "<option disabled selected>Seleccione un oficio</option>";
				for($i=0;$i<count($c_entrada);$i++){
					echo "<option value=".$c_entrada[$i]['idoficio'];
					if ($c_entrada[$i]['contestado']==0){
						echo " style='background-color: gold;'";
					}
					echo ">".$c_entrada[$i]['numero']." : " .$c_entrada[$i]['destinatario']."</option>";
				}
				echo "</select>";
				echo "</li>";

				echo"<li class='nav-item '><a class='nav-link' title='Nuevo' id='lista_area' data-lugar='a_corresps/lista' data-op='pendiente'><i class='far fa-folder-open'></i><span>Pendientes</span></a></li>";

				echo "<li class='nav-item dropdown'>";
					echo "<a class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fas fa-bars'></i>Opciones</a>";
					echo "<div class='dropdown-menu' aria-labelledby='navbarDropdown'>";

					echo "<a class='dropdown-item' title='Nuevo'  id='lista_area' data-lugar='a_corresps/lista' data-op='cancelados' data-funcion='cancelados'><i class='far fa-thumbs-down'></i><span>Cancelados</span></a>";
					if ($db->nivel_captura==1){
						echo "<a class='dropdown-item' title='Nuevo' id='lista_ctodos' data-lugar='a_corresps/imprimir_pre' data-op='pendiente' data-funcion='ctodos'><i class='fas fa-print'></i><span>Imprimir</span></a>";
					}
					if ($db->nivel_captura==1){
						echo "<a class='dropdown-item' title='Nuevo' id='lista_sola' data-lugar='a_corresps/solicitud' data-funcion='area'><i class='fas fa-walking'></i><span>Solicitud</span></a>";
					}

					echo "</div>";
				echo "</li>";
				echo "</ul>";

				echo "<form class='form-inline my-2 my-lg-0' id='form_correspxx' action='' >
					<input class='form-control mr-sm-2' type='search' placeholder='Busqueda global' aria-label='Search' name='buscar' id='buscar'>
					<div class='btn-group'>
				   <button class='btn btn-outline-secondary btn-sm' type='submit' id='lista_buscar' data-lugar='a_corresps/lista' data-valor='buscar' data-funcion='buscar'><i class='fas fa-search'></i></button>
				   <button class='btn btn-outline-secondary btn-sm' type='button' id='lista_avanzada' data-lugar='a_corresps/avanzada' data-funcion='buscar'><i class='fas fa-search-plus'></i></button>
				   </div>
				</form>";
			echo "</div>
		</nav>";
	echo "<div id='trabajo' style='margin-top:5px;'>";
		//include 'lista.php';
	echo "</div>";
?>

<script type="text/javascript">
	var vscan="";
	$(function(){
		console.log("cancelar interval"+vscan);
		clearInterval(vscan);
		$("#trabajo").load('a_corresps/lista.php');
	});
	$(document).on("click","#marcar_oficios",function(e){
		e.preventDefault();
		e.stopImmediatePropagation();
		var id= $("#id").val();
		var div="trabajo";
		$.confirm({
			title: 'Guardar',
			content: '¿Desea marcar el oficio como entregado?',
			buttons: {
				Aceptar: function () {
					var parametros={
						"id":id,
						"function":"marcadoofs"
					};
					$.ajax({
						data:  parametros,
						url: "a_corresps/db_.php",
						type:  'post',
						beforeSend: function () {

						},
						success:  function (response) {
							if (!isNaN(response)){
								Swal.fire({
								  type: 'success',
								  title: "Se marcó correctamente",
								  showConfirmButton: false,
								  timer: 1000
								});

								$.ajax({
									data:  {"id":id},
									url:   "a_corresps/editar.php",
									type:  'post',
									beforeSend: function () {

									},
									success:  function (response) {
										$("#"+div).html(response);
									}
								});
							}
						}
					});
				},
				Cancelar: function () {
					$.alert('Canceled!');
				}
			}
		});

	});
	$(document).on("click","#desmarcar_oficio",function(e){
		var id= $("#id").val();
		var div="trabajo";
		$.confirm({
			title: 'Guardar',
			content: '¿Desea desmarcar el oficio?',
			buttons: {
				Aceptar: function () {
					var parametros={
						"id":id,
						"function":"desmarcadoofs"
					};
					$.ajax({
						data:  parametros,
						url: "a_corresps/db_.php",
						type:  'post',
						beforeSend: function () {

						},
						success:  function (response) {
							if (!isNaN(response)){
								Swal.fire({
								  type: 'success',
								  title: "Se desmarcó",
								  showConfirmButton: false,
								  timer: 1000
								});

								$.ajax({
									data:  {"id":id},
									url:   "a_corresps/editar.php",
									type:  'post',
									beforeSend: function () {

									},
									success:  function (response) {
										$("#"+div).html(response);
									}
								});
							}
						}
					});
				},
				Cancelar: function () {
					$.alert('Canceled!');
				}
			}
		});

	});
	$(document).on('keyup','#destinatario_salida',function(e){
		var e = window.event;
		var tecla = (document.all) ? e.keyCode : e.which;
		var valor=$(this).val();
		var division=valor.length%2;
		if(tecla!=37 && tecla!=38 && tecla!=39 && tecla!=40){
			if(valor.length>2 && division==0){
				$.ajax({
					data:  {
						"valor":valor,
						"function":"remitente_buscar"
					},
					url:   "a_corresps/db_.php",
					type:  'post',
					beforeSend: function () {

					},
					success:  function (response) {
						fila = 0;
						$("#remitente_reg").html(response);
					}
				});
				$("#remitente_reg").show();
			}
		}
		if(tecla == 27 || tecla==9){
			$("#remitente_reg").hide();
		}
		if ( $("#remitentetb").length ) {
			var tab = document.getElementById('remitentetb');
			var filas = tab.getElementsByTagName('tr');
			if(filas.length>1){

				if(tecla==13){
					if(fila==0){
						$('#destinatario_salida').val(filas[1].getElementsByTagName("td")[0].innerHTML);
						$('#cargo').val(filas[1].getElementsByTagName("td")[1].innerHTML);
						$('#dependencia').val(filas[1].getElementsByTagName("td")[2].innerHTML);
					}
					else{
						$('#destinatario_salida').val(filas[fila].getElementsByTagName("td")[0].innerHTML);
						$('#cargo').val(filas[fila].getElementsByTagName("td")[1].innerHTML);
						$('#dependencia').val(filas[fila].getElementsByTagName("td")[2].innerHTML);
					}
					$("#remitente_reg").hide();
					$("#anexos").focus();
				}
			}
			if (e.keyCode==38 && fila>0) num=-1;
			else if(e.keyCode==40 && fila<filas.length-1) num=1;
			else return;
			filas[fila].style.background = 'white';
			fila+=num;
			filas[fila].style.background = 'silver';

			if(fila==0){
				filas[fila].style.background = 'white';
			}
		}
	});
	$(document).on('click','#remitentetb tr',function(e){
	  $('#destinatario_salida').val($(this).find('td:first').html());
	  $('#cargo').val($(this).find('td:nth-child(2)').html());
	  $('#dependencia').val($(this).find('td:nth-child(3)').html());
	  $("#remitente_reg").hide();
	});
	$(document).on("click","#envia_of",function(e){
		e.preventDefault();
        e.stopImmediatePropagation();
		var id= $("#id").val();

		$.confirm({
			title: 'Enviar',
			content: '¿Desea marcar para envio el oficio?',
			buttons: {
				Aceptar: function () {
					var parametros={
						"id":id,
						"entrega":1,
						"function":"envio_of"
					};
					$.ajax({
						data:  parametros,
						url: "a_corresps/db_.php",
						type:  'post',
						beforeSend: function () {

						},
						success:  function (response) {
							if (!isNaN(response)){
								Swal.fire({
								  type: 'success',
								  title: "Se marco para envio",
								  showConfirmButton: false,
								  timer: 1000
								});

								$.ajax({
									data:  {"id":id},
									url:   "a_corresps/editar.php",
									type:  'post',
									beforeSend: function () {

									},
									success:  function (response) {
										$("#trabajo").html(response);
									}
								});
							}
						}
					});
				},
				Cancelar: function () {
					$.alert('Canceled!');
				}
			}
		});
	});
	$(document).on("click","#recibe_of",function(e){
		e.preventDefault();
        e.stopImmediatePropagation();
		var id= $("#id").val();
		$.confirm({
			title: 'Recibir',
			content: '¿Desea marcar como recibido el oficio?',
			buttons: {
				Aceptar: function () {
					var parametros={
						"id":id,
						"entrega":0,
						"function":"envio_of"
					};
					$.ajax({
						data:  parametros,
						url: "a_corresps/db_.php",
						type:  'post',
						beforeSend: function () {

						},
						success:  function (response) {
							if (!isNaN(response)){
								Swal.fire({
								  type: 'success',
								  title: "Se desmarcó",
								  showConfirmButton: false,
								  timer: 1000
								});

								$.ajax({
									data:  {"id":id},
									url:   "a_corresps/editar.php",
									type:  'post',
									beforeSend: function () {

									},
									success:  function (response) {
										$("#trabajo").html(response);
									}
								});
							}
						}
					});
				},
				Cancelar: function () {
					$.alert('Canceled!');
				}
			}
		});
	});
	function oficio_ver(){
		vscan="";
		var id= $("#idoficio_salida").val();
		vscan="";
		$.ajax({
			data:  {
				"id":id},
			url:   "a_corresps/editar.php",
			type:  'post',
			success:  function (response) {
				$("#trabajo").html(response);
			}
		});
	}
	function turnosalidasol(){
		var id=$("#id").val();
		$.confirm({
			title: 'Correspondencia',
			content: '¿Desea solicitar turno al oficio?',
			buttons: {
				Agregar: function () {
					$.ajax({
						data:  {
							"id":id,
							"function":"solicita_turno"
						},
						url:   "a_corresps/db_.php",
						type:  'post',
						success:  function (response) {
							if (!isNaN(response)){
								Swal.fire({
									type: 'success',
									title: "Se solicitó correctamente",
									showConfirmButton: false,
									timer: 1000
								});
							}
							else{
								Swal.fire({
									type: 'error',
									title: response,
									showConfirmButton: false,
									timer: 1000
								});
							}
						}
					});
				},
				Cancelar: function () {

				},
			}
		});
	}
	function cancelado_salida(){
		var id= $("#id").val();
		var parametros={
			"id":id,
			"entrega":1,
			"function":"cancelado_of"
		};
		$.ajax({
			data:  parametros,
			url: "a_corresps/db_.php",
			type:  'post',
			beforeSend: function () {

			},
			success:  function (response) {
				if (!isNaN(response)){
					Swal.fire({
						type: 'success',
						title: "Se marco como cancelado",
						showConfirmButton: false,
						timer: 1000
					});

					$.ajax({
						data:  {"id":id},
						url:   "a_corresps/editar.php",
						type:  'post',
						beforeSend: function () {

						},
						success:  function (response) {
							$("#trabajo").html(response);
						}
					});
				}
				else{
					$.alert(response);
				}
			}
		});
	}
	function descancelado_salida(){
		var id= $("#id").val();
		var parametros={
			"id":id,
			"entrega":0,
			"function":"cancelado_of"
		};
		$.ajax({
			data:  parametros,
			url: "a_corresps/db_.php",
			type:  'post',
			beforeSend: function () {

			},
			success:  function (response) {
				if (!isNaN(response)){
					Swal.fire({
						type: 'success',
						title: "Se marco como cancelado",
						showConfirmButton: false,
						timer: 1000
					});

					$.ajax({
						data:  {"id":id},
						url:   "a_corresps/editar.php",
						type:  'post',
						beforeSend: function () {

						},
						success:  function (response) {
							$("#trabajo").html(response);
						}
					});
				}
				else{
					$.alert(response);
				}
			}
		});
	}
	function aprueba_sal(idrel){
		var id=$("#id").val();
		$.confirm({
			title: 'Correspondencia',
			content: '¿Desea aprobar el turno al oficio?',
			buttons: {
				Agregar: function () {
					$.ajax({
						data:  {
							"id":id,
							"idrel":idrel,
							"function":"turnasol"
						},
						url:   "a_corresps/db_.php",
						type:  'post',
						beforeSend: function () {

						},
						success:  function (response) {
							if (!isNaN(response)){
								$("#trabajo").load("a_corresps/editar.php?id="+id);
							}
							else{
								alert(response);
							}
						}
					});
				},
				Cancelar: function () {

				},
			}
		});
	}
	function salidac () {
		baguetteBox.run('.baguetteBoxOne');
	};
	function respuestac () {
		$.datepicker.setDefaults($.datepicker.regional['es']);
		$( "#frecibio" ).datepicker();
	};
	function respondesalida(){
		var id= $("#id").val();
		$("#modal_form").load("a_corresps/form_respuesta.php?id="+id);
	}
	function escanear(){
		var id= $("#id").val();
		$.confirm({
			title: 'Correspondencia',
			content: '¿Desea escanear el oficio seleccionado?',
			buttons: {
				Escanear: function () {
					var parametros={
						"id":id,
						"function":"escanear"
					};
					$.ajax({
						data:  parametros,
						url: "a_corresps/db_.php",
						type:  'post',
						success:  function (response) {
						}
					});
				},
				Cancelar: function () {

				},
			}
		});
	}
	function escan_salida(){
		var id= $("#id").val();
		console.log("salida:"+id+vscan);
		$("#archivos").load("a_corresps/archivos.php?id="+id);
	}
</script>
