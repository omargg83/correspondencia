<?php
	require_once("db_.php");
	echo "<nav class='navbar navbar-expand-lg navbar-light bg-light '>

	<a class='navbar-brand' ><i class='fas fa-users'></i> Personal</a>

	  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	  </button>
		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
			<ul class='navbar-nav mr-auto'>";
			echo"<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='lista_comision' data-lugar='a_personal/lista'><i class='fas fa-list-ul'></i><span>Lista</span></a></li>";

			if($db->nivel_personal==0 or $db->nivel_personal==11 or $db->nivel_personal==1 or $db->nivel_personal==2 or $db->nivel_personal==3 or $db->nivel_personal==4 or $db->nivel_personal==10){
				echo"<li class='nav-item active'><a class='nav-link barranav izq' title='Nuevo' id='new_personal' data-lugar='a_personal/editar'><i class='fas fa-plus'></i><span>Nuevo</span></a></li>";
				echo "<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='lista_validar' data-lugar='a_personal/validar'><i class='fas fa-check-double'></i><span>Validar</span></a></li>";
				echo "<li class='nav-item active'><a class='nav-link barranav' title='Imprimir' id='lista_imprime' data-lugar='a_personal/imprimir_pre'><i class='fas fa-print'></i><span>Imprimir</span></a></li>";
			}

			if($db->nivel_personal==0){
				echo"<li class='nav-item active'><a class='nav-link barranav' title='Nuevo' id='new_cargo' data-lugar='a_personal/lista_cargos'><i class='fas fa-briefcase'></i><span>Cargo</span></a></li>";
				echo"<li class='nav-item active'><a class='nav-link barranav' title='Nuevo' id='lista_permisos' data-lugar='a_personal/lista_permisos'><i class='fas fa-key'></i><span>Permisos</span></a></li>";

			}
			echo "</ul>";

			echo "<form class='form-inline my-2 my-lg-0' id='consulta_avanzada' action='' data-destino='a_personal/lista' data-funcion='guardar' data-div='trabajo'>
			<input class='form-control mr-sm-2' type='search' placeholder='Busqueda global' aria-label='Search' name='valor' id='valor'>
			<div class='btn-group'>
			<button class='btn btn-outline-secondary btn-sm' type='submit' title='Buscar' ><i class='fas fa-search'></i></button>
			</div>
			</form>";
		echo "
	  </div>
	</nav>";
	echo "<div id='trabajo'>";
		include 'lista.php';
	echo "</div>";
?>
<script type="text/javascript">

		$(document).on('click','#cambiar',function(e){
			e.preventDefault();
			var xyId= $("#id").val();

			var parametros={
				"function":"cambiar_user",
				"id": xyId
			};

			$.ajax({
				data:  parametros,
				url: "a_personal/db_.php",
				type: "post",
				beforeSend: function () {

				},
				success:  function (response) {
					if (!isNaN(response)){
						Swal.fire({
						  type: 'success',
						  title: "Se guardó correctamente",
						  showConfirmButton: false,
						  timer: 1000
						});
						window.location.replace("");
					}
					else{
						$.alert(response);
					}
				}
			});
		});
		$(document).on('click','#dar_baja',function(e){
			e.preventDefault();
			var xyId= $("#id").val();
			$.confirm({
				title: 'Guardar',
				content: '¿Desea dar de baja al usuario?',
				buttons: {
					Aceptar: function () {
						////////////////////////
						var parametros={
							"function":"baja",
							"id": xyId
						};

						$.ajax({
							data:  parametros,
							url: "a_personal/db_.php",
							type: "post",
							beforeSend: function () {

							},
							success:  function (response) {
								if (!isNaN(response)){
									Swal.fire({
									  type: 'success',
									  title: "Se dio de baja correctamente",
									  showConfirmButton: false,
									  timer: 1000
									});
								}
								else{
									$.alert(response);
								}
							}
						});
						////////////////////////
					},
					Cancelar: function () {
						$.alert('Canceled!');
					}
				}
			});
		});
		$(document).on('click','#agregar_permiso',function(e){
			e.preventDefault();
			var xyId= $("#id").val();
			var aplicacion= $("#aplicacion").val();
			var acceso= $("#acceso").val();
			var captura= $("#captura").val();
			var nivelx= $("#nivelx").val();

			console.log(captura);

			var parametros={
				"function":"permisos",
				"aplicacion":aplicacion,
				"acceso":acceso,
				"captura":captura,
				"nivelx":nivelx,
				"id": xyId
			};

			$.ajax({
				data:  parametros,
				url: "a_personal/db_.php",
				type: "post",
				beforeSend: function () {

				},
				success:  function (response) {
					if (!isNaN(response)){
						Swal.fire({
						  type: 'success',
						  title: "Se guardó correctamente",
						  showConfirmButton: false,
						  timer: 1000
						});
						$("#permisos").load("a_personal/form_permisos.php?id="+xyId);
					}
					else{
						$.alert(response);
					}
				}
			});
		});
		$(document).on('change','#aplicacion_per',function(e){
			e.preventDefault();
			var aplicacion_per= $("#aplicacion_per").val();
			$("#permisos").load("a_personal/lista_permisodetalle.php?id="+aplicacion_per);
		});

</script>
