<?php
	require_once("db_.php");
	$listado = $db->personal();

	$id=$_REQUEST['id'];
	if($id>0){
			$listado_edit = $db->personal_edit($id);
			$t_estudio=$listado_edit['estudio'];
			$t_nombre=$listado_edit['nombre'];
			$t_idcargo=$listado_edit['idcargo'];
			$t_idpuesto=$listado_edit['idpuesto'];
			$t_rfc=$listado_edit['rfc'];
			$t_idprogra=$listado_edit['idprogra'];
			$t_idprogra=$listado_edit['idprogra'];
			$t_idpuesto=$listado_edit['idpuesto'];
			$t_area=$listado_edit['idarea'];
			$t_foto=$listado_edit['file_foto'];
			$t_correo=$listado_edit['correo'];
			$t_usuario=$listado_edit['usuario'];
			$t_pass=$listado_edit['pass'];
			$autoriza=$listado_edit['autoriza'];
		}
		else{
			$autoriza="1";
			$t_estudio="";
			$t_nombre="";
			$t_idcargo=133;
			$t_idpuesto=1;
			$t_rfc="";
			$t_idprogra=1;
			$t_credencial=0;
			$t_idprogra=1;
			$t_idpuesto=1;
			$t_compensa=0;
			$t_area=$_SESSION['idarea'];
			$t_foto="";
			$t_calle="";
			$t_numero="";
			$t_colonia="";
			$t_cpostal="";
			$t_estado="";
			$t_municipio="";
			$t_telefono="";
			$t_telcel="";
			$t_directorio="";
			$t_grupo_sanguineo="";
			$t_mama="";
			$t_papa="";
			$t_hijos="";
			$t_fecha_hijo=date("d-m-Y");
			$t_correo="";
			$t_usuario="";
			$t_pass="";
			$t_observa="";
			$nombra="";
		}
		$area = $db->area_ver($db->nivel_personal);

		$puesto = $db->puesto();

		$cargo = $db->cargo($id,$t_area);
		echo "<form autocomplete=off id='form_personal' action='' data-lugar='a_personal/db_' data-funcion='guardar' data-destino='a_personal/editar'>";
		echo "<input  type='hidden' id='id' NAME='id' value='$id'>";
		echo "<div class='container'>";
		echo "<div class='card'>";

		echo "<div class='card-header'>Personal No. $id</div>";
		echo "<div class='card-body'>";
			echo  "<div class='row'>";
				echo  "<div class='col-sm-2'>";
					echo "<div class='form-group' id='imagen_div'>";
							echo "<img src='".$db->doc.trim($t_foto)."' class='img-thumbnail' width='100%'>";
					echo "</div>";
				echo "</div>";

				echo  "<div class='col-sm-10'>";
					echo  "<div class='card'>";
						echo "<div class='card-header' >";
							$disabled="";
							if($id==0){
								$disabled='disabled';
							}
							echo "
							<ul class='nav nav-tabs card-header-tabs nav-fill' id='myTab' role='tablist'>
								<li class='nav-item'>
									<a class='nav-link active' id='ssh-tab' data-toggle='tab' href='#ssh' role='ssh' aria-controls='home' aria-selected='true'>Datos</a>
								</li>

								";

								if($db->nivel_personal==0 or $_SESSION['administrador']==1){
									echo "<li class='nav-item'>
										<a class='nav-link $disabled' id='permiso-tab' data-toggle='tab' href='#permiso' role='tab' aria-controls='permiso' aria-selected='false'>Permisos</a>
									</li>";
								}

							echo "</ul>
						</div>
						<div class='card-body'>";

							echo "<div class='tab-content' id='myTabContent'>";
								echo "<div class='tab-pane fade show active' id='ssh' role='tabpanel' aria-labelledby='ssh-tab'>";
									echo "<div class='row'>";
										echo  "<div class='col-sm-3'>";
											echo "<label for='rfc'>RFC</label>";
											echo "<input class='form-control ' type='text' id='rfc' NAME='rfc' value='$t_rfc' maxlength='13' placeholder='RFC' title='Captura de RFC'  data-placement='bottom'>";
										echo "</div>";

										echo  "<div class='col-sm-2 '>";
											echo "<label for='prof'>Profesión</label>";
											echo "<input class='form-control' type='text' id='prof' NAME='prof' value='$t_estudio' maxlength='10' placeholder='siglas nivel estudios'>";
										echo "</div>";

										echo  "<div class='col-sm-7'>";
											echo "<label for='nombre'>Nombre</label>";
											echo "<input class='form-control' type='text' id='nombre' NAME='nombre' value='$t_nombre' size='60' maxlength='70' placeholder='Nombre completo' required autocomplete='OFF'>";

										echo "</div>";

										echo  "<div class='col-sm-6'>";
											echo "<label for='idarea'>Area</label>";
											echo "<select class='form-control' name='idarea' id='idarea' >";
											echo "<option value='' disabled selected style='color: silver;'>Seleccione ...</option>";
											for($i=0;$i<count($area);$i++){
												echo  "<option value='".$area[$i]['idarea']."'";
												if ($t_area==$area[$i]['idarea']){echo  " selected";}
												echo  ">".$area[$i]['area']."</option>";
											}
											echo  "</select>";
										echo "</div>";


										echo  "<div class='col-sm-6' id='cargox'>";
											echo "<label for='idcargo'>Cargo (Es para la generación del organigrama)</label>";
											echo "<select class='form-control' name='idcargo' id='idcargo'>";
											echo "<option value='' selected style='color: silver;'>Seleccione...</option>";
											for($i=0;$i<count($cargo);$i++){
												echo  "<option value='".$cargo[$i]['id']."'";
												if ($t_idcargo==$cargo[$i]['id']){echo  " selected";}
												echo  ">".$cargo[$i]['cargo']."</option>";
											}
											echo  "</select>";

										echo "</div>";


										echo  "<div class='col-sm-4' >";
											echo "<label>Usuario:</label>";
											echo "<input type='text' class='form-control' id='usuariot' name='usuariot' value='".$t_usuario."' size='30' maxlength='45'";
											echo " placeholder='notificar a usuario, es clave de acceso' autocomplete='OFF'>";
										echo "</div>";

										echo  "<div class='col-sm-4'>";
											echo "<label>Contraseña:</label>";
											echo  "<input type='password' id='contra' class='form-control'  NAME='contra' value='".$t_pass."' size='20' maxlength='10' ";
											if($id>0){
												echo " readonly";
											}
											echo " autocomplete=OFF>";
										echo "</div>";


										echo  "<div class='col-sm-4'>";
											echo "<label for='correo'>Correo:</label>";
											echo "<input type='email' class='form-control' id='correo' name='correo' value='".$t_correo."' placeholder='Correo electrónico válido'>";
										echo "</div>";

									echo "</div>";
								echo "</div>";


								if($db->nivel_personal==0 or $_SESSION['administrador']==1){
									echo "<div class='tab-pane fade' id='permiso' role='tabpanel' aria-labelledby='permiso-tab'>";
										echo "<div class='row'>";

											echo "<div class='col-sm-3'>";
												echo "<label>Activo: </label>";
												echo "<input type='checkbox' name='autoriza' id='autoriza' value=1";
												if($autoriza==1){ echo " checked";}
												echo ">";
											echo "</div>";
										echo "</div>";
										echo "<div class='row'>";
											echo "<div class='col-sm-3'>";
												echo "<label for='prof'>Modulo:</label>";
												echo "<select id='aplicacion' name='aplicacion' class='form-control'>";
												echo $db->modulos();
												echo "</select>";
											echo "</div>";

											echo "<div class='col-sm-3'>";
												echo "<label>Acceso</label>";
												echo "<select id='acceso' name='acceso' class='form-control'>";
												echo "<option value='0' >Sin acceso</option>";
												echo "<option value='1' >Acceso</option>";
												echo "</select>";
											echo "</div>";

											echo "<div class='col-sm-3'>";
												echo "<label>Captura</label>";
												echo "<select id='captura' name='captura' class='form-control'>";
												echo "<option value='0' >Sin captura</option>";
												echo "<option value='1' >Captura</option>";
												echo "</select>";
											echo "</div>";

											echo "<div class='col-sm-3'>";
												echo "<label for='prof'>Nivel</label>";
												echo "<select id='nivelx' name='nivelx' class='form-control'>";
												echo "<option value='0' >0-Administrador</option>";
												echo "<option value='1' >1-Subsecretarío</option>";
												echo "<option value='2' >2-Dirección</option>";
												echo "<option value='3' >3-Subdirector</option>";
												echo "<option value='4' >4-Coordinador Administrativo</option>";
												echo "<option value='5' >5-Jefe Depto.</option>";
												echo "<option value='6' >6-Coordinador</option>";
												echo "<option value='7' >7-Secretaria</option>";
												echo "<option value='8' >8-Chofer</option>";
												echo "<option value='9' >9-Personal</option>";
												echo "<option value='10' >10-Informatica</option>";
												echo "<option value='11' >11-Administrador del sistema</option>";
												echo "<option value='12' >12-Oficialia</option>";
												echo "</select>";
											echo "</div>";

											echo "<div class='col-sm-2'>";
												echo "<button class='btn btn-outline-secondary btn-sm' type='button' id='agregar_permiso'><i class='fa fa-check'></i>Agregar</button>";
											echo "</div>";
										echo "</div><br>";
										echo "<div class='row' >";
											echo "<div class='col-sm-12' id='permisos'>";
											echo "</div>";
										echo "</div>";
									echo "</div>";
								}
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
			echo "<div class='card-footer'>";
				echo "<div class='btn-group' role='group' aria-label='Basic example'>";
					echo "<button class='btn btn-outline-secondary btn-sm' type='submit' title='Guardar cambios' ><i class='far fa-save'></i>Guardar</button>";

					if($db->nivel_personal==0 or $_SESSION['administrador']==1){
						echo "<button class='btn btn-danger btn-sm' type='button' id='cambiar' title='Entrar a la cuenta' ><i class='fas fa-user-shield'></i>Perfil</button>";
					}
					echo "<button class='btn btn-outline-secondary btn-sm' type='button' id='dar_baja' title='Dar de baja' ><i class='fas fa-user-slash'></i>Baja</button>";
					if($id>0){
						echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_pass' data-id='$id' data-lugar='a_personal/form_pass' title='Cambiar contraseña' ><i class='fas fa-key'></i>Contraseña</button>";
						echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_cargo' data-id='$id' data-id2='$t_idcargo' data-id3='$t_area' data-lugar='a_personal/form_cargo' title='Cambiar cargo'><i class='fas fa-sitemap'></i>Cargo</button>";
					}

					echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-toggle='modal' data-target='#myModal' id='fileup_foto' data-ruta='$db->doc' data-tabla='personal' data-campo='file_foto' data-tipo='1' data-id='$id' data-keyt='idpersona' data-destino='a_personal/editar' data-iddest='$id' data-ext='.jpg,.png' title='Subir foto'><i class='fas fa-cloud-upload-alt'></i>Foto</button>";

					echo "<button class='btn btn-outline-secondary btn-sm' id='lista_penarea' data-lugar='a_personal/lista' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</form>";
?>
	<script>
		$(function() {
			var id= $("#id").val();
			$("#permisos").load("a_personal/form_permisos.php?id="+id);
			baguetteBox.run('.baguetteBoxOne');
			fechas();
		});
	</script>
