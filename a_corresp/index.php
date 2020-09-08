<?php
require_once("db_.php");
$_SESSION['tmp']="";
$c_entrada = json_decode($db->c_entrada(),true);
echo "<nav class='navbar navbar-expand-lg navbar-light bg-light bg-danger '>
<button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
<span class='navbar-toggler-icon'></span>
</button>
<a class='navbar-brand' ><i class='fas fa-arrow-circle-down'></i>Entrada</a>
<div class='collapse navbar-collapse' id='navbarSupportedContent'>";

echo "<ul class='navbar-nav mr-auto'>";
if ($db->nivel_captura==1){
	echo"<li class='nav-item active'><a class='nav-link' title='Nuevo' id='new_corresp' data-lugar='a_corresp/editar'><i class='fas fa-plus'></i><span>Nuevo</span></a></li>";
}
echo "<li class='nav-item' id='per_lista'>";
echo "<select name='idoficio' id='idoficio' class='form-control' style='width:250px !important' onchange='idoficio(this)'>";
echo "<option disabled selected>Seleccione un oficio</option>";

foreach($c_entrada as $key){
	echo "<option value=".$key['idoficio'];
	if ($key['contestado']==0){
			echo " style='background-color: gold;'";
	}
	echo ">".$key['numero']." : " .$key['remitente']."</option>";
}

echo "</select>";
echo "</li>";

echo"<li class='nav-item active'><a class='nav-link barranav' title='Concentrado' id='lista_area' data-lugar='a_corresp/lista'><i class='far fa-folder-open'></i><span>Pendientes</span></a></li>";
echo"<li class='nav-item active'><a class='nav-link barranav' title='Nuevo' id='lista_entrada' data-lugar='a_corresp/firma' data-funcion='entrada'><i class='fas fa-signature'></i><span>Firma</span></a></li>";

	echo "<li class='nav-item dropdown'>";
		echo "<a class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fas fa-bars'></i>Opciones</a>";
		echo "<div class='dropdown-menu' aria-labelledby='navbarDropdown'>";

		echo "<a class='dropdown-item' title='Nuevo' id='lista_recep' data-lugar='a_corresp/lista' data-funcion='recepcion'><i class='fas fa-download'></i><span>Recibir</span></a>";

		echo "<a class='dropdown-item' title='Nuevo' id='lista_libro' data-lugar='a_corresp/libro' data-funcion='libro'><i class='fas fa-signature'></i><span>Libro</span></a>";
		echo "<a class='dropdown-item' title='Nuevo' id='lista_ctodos' data-lugar='a_corresp/lista' data-funcion='ctodos'><i class='fas fa-globe-americas'></i><span>Todos</span></a>";
		echo "<hr>";
		echo "<a class='dropdown-item' title='Nuevo' id='lista_penarea' data-lugar='a_corresp/pendientes' data-funcion='area'><i class='fas fa-walking'></i><span>Por persona</span></a>";
		if ($db->nivel_captura==1){
			echo "<a class='dropdown-item' title='Nuevo' id='lista_sola' data-lugar='a_corresp/solicitud' data-funcion='area'><i class='fas fa-walking'></i><span>Solicitud</span></a>";
			echo "<a class='dropdown-item' title='Analisis' id='lista_rep' data-lugar='a_corresp/reporte1' data-funcion='area'><i class='fas fa-walking'></i><span>Analisis</span></a>";
		}
		echo "<a class='dropdown-item' title='Reporte' id='lista_rep1' data-lugar='a_corresp/reporte' data-funcion='area'><i class='fas fa-walking'></i><span>Reportes</span></a>";
		echo "<a class='dropdown-item' title='Reporte' id='lista_rep2' data-lugar='a_corresp/reporte2' data-funcion='area'><i class='fas fa-walking'></i><span>Pendientes x Persona</span></a>";
		echo "</div>";
	echo "</li>";
	//echo"<li class='nav-item active'><a class='nav-link barranav' title='Concentrado' id='lista_reporte1' data-lugar='a_corresp/reporte'><i class='far fa-folder-open'></i><span>Reportes</span></a></li>";
	//echo"<li class='nav-item active'><a class='nav-link barranav' title='Concentrado' id='lista_reporte2' data-lugar='a_corresp/reporte1'><i class='far fa-folder-open'></i><span>Analisis</span></a></li>";
echo "</ul>";

echo "<form class='form-inline my-2 my-lg-0' id='form_correspxx' action='' >
<input class='form-control mr-sm-2' type='search' placeholder='Busqueda global' aria-label='Search' name='buscar' id='buscar'>
<div class='btn-group'>
<button class='btn btn-outline-secondary btn-sm' type='submit' id='lista_buscar' data-lugar='a_corresp/lista' data-valor='buscar' data-funcion='buscar'><i class='fas fa-search'></i></button>
<button class='btn btn-outline-secondary btn-sm' type='button' id='lista_avanzada' data-lugar='a_corresp/avanzada' data-funcion='buscar'><i class='fas fa-search-plus'></i></button>
</div>
</form>";

echo "</div>
</nav>";

echo "<div id='trabajo' style='margin-top:5px;'>";

echo "</div>";
?>
<script type="text/javascript">
var vscan="";
var cmb_tmp="";
$(function(){
	$("#trabajo").load('a_corresp/lista.php');
	cmb_tmp=window.setInterval("pendientes_cmb()",20000);
});

function firmar_cor(tipof){
	var id = $(this).data('id');
	var idpersona=$("#idpersona_firma").val();
	var sel = $("[id^='ck_of'][type=checkbox]:checked").map(function(_, el) {
		return $(el).val();
	}).get();
	$("#modal_form").load("a_corresp/firma_final.php?idpersona="+idpersona+"&tipof="+tipof+"&oficios="+sel);
}
function persona_firma(){
	var id=$("#idpersona_firma").val();
	$("#resultado").load('a_corresp/lista.php?funcion=entrada&idpersona_firma='+id);
}
function firma_final(){
	var idpersona=$("#firma_t").val();
	var contra=$("#contra").val();
	var idturnado=$("#idturnado").val();
	var tipof=$("#tipof").val();

	var sel = $("[id^='par_firma_'][type=checkbox]:checked").map(function(_, el) {
		return $(el).val();
	}).get();

	$.ajax({
		data:  {
			"idpersona":idpersona,
			"function":"firma_entrega",
			"contra":contra,
			"idturnado":idturnado,
			"tipof":tipof,
			"par_firma":sel
		},
		url:   "a_corresp/db_.php",
		type:  'post',
		success:  function (response) {
			if (!isNaN(response)){
				$("#trabajo").load('a_corresp/lista.php');
				$('#myModal').modal('hide');
				Swal.fire({
					position: 'top-end',
					type: 'success',
					title: 'Se firmó correctamente',
					showConfirmButton: false,
					timer: 1000
				})
			}
			else{
				$.alert(response);
			}
		}
	});
}
function idoficio(){
	var id=$('#idoficio').val();
	$.ajax({
		data:  {
			"id":id
		},
		url:   "a_corresp/editar.php",
		type:  'post',
		success:  function (response) {
			$("#trabajo").html(response);
		}
	});
}
$(document).on('click','#borra_respuesta',function(e){
	e.preventDefault();
	var idoficiop = $(this).data('id');
	$.confirm({
		title: 'Correspondencia',
		content: '¿Desea eliminar la respuesta?',
		buttons: {
			Eliminar: function () {
				$.ajax({
					data:  {
						"idoficiop":idoficiop,
						"function":"borrarespuesta"
					},
					url:   "a_corresp/db_.php",
					type:  'post',
					beforeSend: function () {

					},
					success:  function (response) {
					}
				});
			},
			Cancelar: function () {

			},
		}
	});
});
$(document).on('keyup','#numoficio',function(e){
	e.preventDefault();
	var e = window.event;
	var tecla = (document.all) ? e.keyCode : e.which;
	var numero=$("#numero").val();
	var numoficio=$("#numoficio").val();
	var fechaofi=$("#fechaofi").val();
	console.log(numero);
	if(tecla == 27){
		$("#duplicado").hide();
		$("#fechaofi").focus();
	}
	else{
		if(numoficio.length>=2){
			$.ajax({
				data:  {
					"numero":numero,
					"numoficio":numoficio,
					"fechaofi":fechaofi,
					"function":"duplicado"
				},
				url:   "a_corresp/db_.php",
				type:  'post',
				beforeSend: function () {
					$("#duplicado").html("buscando...");
				},
				success:  function (response) {
					if(response.length<=173){
						$("#duplicado").hide();
					}
					else{
						$("#duplicado").show();
						$("#duplicado").html(response);
					}
				}
			});
		}
	}
});
$(document).on('click',':input',function(e){
	$("#duplicado").hide();
	$("#remitente_sug").hide();
});
$(document).on('keypress','#numoficio',function(e){
	var e = window.event;
	var tecla = (document.all) ? e.keyCode : e.which;
	if(tecla==47) return false;
});
$(document).on('keyup','#remitente',function(e){
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
				url:   "a_corresp/db_.php",
				type:  'post',
				beforeSend: function () {
					$("#remitente_sug").html("buscando...");
				},
				success:  function (response) {
					fila = 0;
					$("#remitente_sug").html(response);
				}
			});
			$("#remitente_sug").show();
		}
	}
	if(tecla == 27 || tecla==9){
		$("#remitente_sug").hide();
	}
	if ( $("#remitentetb").length ) {
		var tab = document.getElementById('remitentetb');
		var filas = tab.getElementsByTagName('tr');
		if(filas.length>1){

			if(tecla==13){
				if(fila==0){
					$('#remitente').val(filas[1].getElementsByTagName("td")[0].innerHTML);
					$('#cargo').val(filas[1].getElementsByTagName("td")[1].innerHTML);
					$('#dependencia').val(filas[1].getElementsByTagName("td")[2].innerHTML);
				}
				else{
					$('#remitente').val(filas[fila].getElementsByTagName("td")[0].innerHTML);
					$('#cargo').val(filas[fila].getElementsByTagName("td")[1].innerHTML);
					$('#dependencia').val(filas[fila].getElementsByTagName("td")[2].innerHTML);
				}
				$("#remitente_sug").hide();
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
	$('#remitente').val($(this).find('td:first').html());
	$('#cargo').val($(this).find('td:nth-child(2)').html());
	$('#dependencia').val($(this).find('td:nth-child(3)').html());
	$("#remitente_sug").hide();
});
$(document).on('click','#buscar_oficio',function(e){
	e.preventDefault();
	var texto=$('#oficiosal').val();

	$.ajax({
		data:  {
			"texto":texto,
			"function":"busca_salida"
		},
		url:   "a_corresp/db_.php",
		type:  'post',
		beforeSend: function () {

		},
		success:  function (response) {
			$("#resultadosx").html(response);
		}
	});

});
$(document).on('click','#agregar_corresp',function(e){
	e.preventDefault();

	var id=$("#id").val();
	var id_of=$("#id_of").val();
	$.confirm({
		title: 'Correspondencia',
		content: '¿Desea agregar el oficio seleccionado como respuesta?',
		buttons: {
			Agregar: function () {

				$.ajax({
					data:  {
						"id":id,
						"idresp":id_of,
						"function":"agregaroficio"
					},
					url:   "a_corresp/db_.php",
					type:  'post',
					beforeSend: function () {

					},
					success:  function (response) {
						$("#trabajo").load('a_corresp/editar.php?id='+id);
					}
				});
			},
			Cancelar: function () {

			},
		}
	});

});

function oficioss(){
	var idoficio = $("#id").val();
	$("#modal_form").load("a_corresp/corresps.php?id="+idoficio);
}
function aprueba_salida(idrel){
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
					url:   "a_corresp/db_.php",
					type:  'post',
					beforeSend: function () {

					},
					success:  function (response) {
						if (!isNaN(response)){
							$("#trabajo").load("a_corresp/editar.php?id="+id);
						}
					}
				});
			},
			Cancelar: function () {

			},
		}
	});
};
function cancela_salida(idrel){
	var id=$("#id").val();
	$.confirm({
		title: 'Correspondencia',
		content: '¿Desea cancelar el turno al oficio?',
		buttons: {
			Aceptar: function () {
				$.ajax({
					data:  {
						"id":id,
						"idrel":idrel,
						"function":"cancelasol"
					},
					url:   "a_corresp/db_.php",
					type:  'post',
					beforeSend: function () {

					},
					success:  function (response) {
						if (!isNaN(response)){
							$("#trabajo").load("a_corresp/editar.php?id="+id);
						}
					}
				});
			},
			Cancelar: function () {

			},
		}
	});
};
function turnar_c () {
	var id=$("#id").val();
	var remitente=$("#remitente").val();
	var asunto=$("#asunto").val();
	var nivel=$("#nivel").val();

	if((remitente.length>0 && asunto.length>0) || nivel==12) {
		$('#modal_form').load("a_corresp/form_turnar.php?id="+id, function(){
		});
		$('#myModal').modal('show');
	}
	else{
		Swal.fire({
			type: 'error',
			title: "No se puede turnar porque falta información de remitente o asunto",
			showConfirmButton: false,
			timer: 2000
		});
	}
};
function responder_c () {
	var id=$("#id").val()
	$('#modal_form').load("a_corresp/form_respuesta.php?id="+id, function(){
		$.datepicker.setDefaults($.datepicker.regional['es']);
		$( "#fecharesp" ).datepicker();
	});
}
function turnosol_entrada(){
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
					url:   "a_corresp/db_.php",
					type:  'post',
					beforeSend: function () {

					},
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
			}
		}
	});
}
function datos_c(id){
	$('#modal_form').load("a_corresp/form_datos.php?id="+id);
}

function escanear_e(){
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
					url: "a_corresp/db_.php",
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
function escaneo(){
	var id= $("#id").val();
	$("#archivos").load("a_corresp/archivos.php?id="+id);
}

function pendientes_cmb(){
	$.ajax({
		data:  {
			"function":"pendientes_cmb"
		},
		url:   'a_corresp/db_.php',
		type:  'post',
		timeout:3000,
		success:  function (response) {
			$("#per_lista").html(response);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			if(textStatus==="timeout") {
			}
		}
	});

}
function firma_unica(idoficio, numero){
	$.confirm({
		title: 'Correspondencia',
		content: '¿Desea firmar de recibido oficio: '+ numero +'?',
		buttons: {
			Firmar: function () {
				var parametros={
					"id":idoficio,
					"function":"firmar_unico"
				};
				$.ajax({
					data:  parametros,
					url: "a_corresp/db_.php",
					type:  'post',
					success:  function (response) {
						if (!isNaN(response)){
							$("#trabajo").load('a_corresp/lista.php');
							$('#myModal').modal('hide');
							Swal.fire({
								position: 'top-end',
								type: 'success',
								title: 'Se firmó correctamente',
								showConfirmButton: false,
								timer: 1000
							})
						}
					}
				});
			},
			Cancelar: function () {

			},
		}
	});
}

</script>
