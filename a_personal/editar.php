<?php
	require_once("db_.php");
	$listado = $db->personal();

	$id=$_REQUEST['id'];
	if($id>0){
			$listado_edit = $db->personal_edit($id);
			$personal_doc = $db->personal_doc($id);
			$concepto07=$listado_edit['concepto07'];
			$sueldo=$listado_edit['sueldo'];
			$t_estudio=$listado_edit['estudio'];
			$t_nombre=$listado_edit['nombre'];
			$t_idcargo=$listado_edit['idcargo'];
			$t_idpuesto=$listado_edit['idpuesto'];
			$t_clave=$listado_edit['clave'];
			$t_codigo=$listado_edit['codigo'];
			$t_rfc=$listado_edit['rfc'];
			$t_curp=$listado_edit['curp'];
			$t_idplaza=$listado_edit['idplaza'];
			$t_idprogra=$listado_edit['idprogra'];
			$t_categoria=$listado_edit['categoria'];
			$t_categorian=$listado_edit['categorian'];
			$t_credencial=$listado_edit['credencial'];
			$t_idprogra=$listado_edit['idprogra'];
			$t_idpuesto=$listado_edit['idpuesto'];
			$t_compensa=$listado_edit['compensacion'];
			$t_observa=$listado_edit['observaciones'];
			$t_horario=$listado_edit['horario'];
			$t_area=$listado_edit['idarea'];
			$t_foto=$listado_edit['file_foto'];
			$fingreso=$listado_edit['fingreso'];
			if(strlen($listado_edit['fingreso'])>0){
				$fingreso=fecha($listado_edit['fingreso']);
			}
			else{
				$fingreso="";
			}
			$t_lunes=$listado_edit['lunes'];
			$t_martes=$listado_edit['martes'];
			$t_miercoles=$listado_edit['miercoles'];
			$t_jueves=$listado_edit['jueves'];
			$t_viernes=$listado_edit['viernes'];
			$t_sabado=$listado_edit['sabado'];
			$idprofesion=$listado_edit['idprofesion'];
			$idescolaridad=$listado_edit['idescolaridad'];
			$idespecialidad=$listado_edit['idespecialidad'];
			$idacredita=$listado_edit['idacredita'];
			$t_cedula=$listado_edit['cedula'];
			$idfuncion=$listado_edit['idfuncion'];
			$t_calle=$listado_edit['calle'];
			$t_numero=$listado_edit['numero'];
			$t_colonia=$listado_edit['colonia'];
			$t_cpostal=$listado_edit['cpostal'];
			$t_estado=$listado_edit['estado'];
			$t_municipio=$listado_edit['municipio'];
			$t_telefono=$listado_edit['telefono'];
			$t_telcel=$listado_edit['telcel'];
			$t_directorio=$listado_edit['directorio'];
			$t_grupo_sanguineo=$listado_edit['grupo_sanguineo'];
			$t_mama=$listado_edit['mama'];
			$t_papa=$listado_edit['papa'];
			$t_hijos=$listado_edit['hijos'];
			if(strlen($listado_edit['fecha_hijo'])>0){
				$t_fecha_hijo=fecha($listado_edit['fecha_hijo']);
			}
			else{
				$t_fecha_hijo="";
			}
			$t_correo=$listado_edit['correo'];
			$t_correoinstitucional=$listado_edit['correoinstitucional'];
			$t_usuario=$listado_edit['usuario'];
			$t_nick=$listado_edit['nick'];
			$t_pass=$listado_edit['pass'];
			$nombra=$listado_edit['nombra'];
			$autoriza=$listado_edit['autoriza'];
		}
		else{
			$autoriza="1";
			$t_curp="";
			$concepto07=0;
			$sueldo=0;
			$t_estudio="";
			$t_nombre="";
			$t_idcargo=133;
			$t_idpuesto=1;
			$t_clave="";
			$t_codigo="";
			$t_rfc="";
			$t_idplaza=1;
			$t_idprogra=1;
			$t_categoria="A";
			$t_categorian="";
			$t_credencial=0;
			$t_idprogra=1;
			$t_idpuesto=1;
			$t_compensa=0;
			$t_horario="";
			$t_area=$_SESSION['idarea'];
			$t_foto="";
			$fingreso = date("d-m-Y");
			$t_lunes="";
			$t_martes="";
			$t_miercoles="";
			$t_jueves="";
			$t_viernes="";
			$t_sabado="";
			$idprofesion="";
			$idescolaridad="";
			$idacredita="";
			$t_cedula="";
			$idfuncion="";
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
			$t_correoinstitucional="";
			$t_usuario="";
			$t_nick="";
			$t_pass="";
			$t_observa="";
			$idespecialidad=0;
			$nombra="";
		}
		$area = $db->area_ver($db->nivel_personal);

		$puesto = $db->puesto();
		$plaza = $db->plaza();
		$programa = $db->programa();
		$profesion = $db->profesion();
		$escolaridad = $db->escolaridad();
		$listado_acredita = $db->personal_acredita();
		$listado_esp = $db->personal_especialidad();
		$personal_fun = $db->personal_funcion();

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
								<li class='nav-item'>
									<a class='nav-link $disabled' id='home-tab' data-toggle='tab' href='#home' role='tab' aria-controls='home' aria-selected='true'>Datos SSH</a>
								</li>

								<li class='nav-item'>
									<a class='nav-link $disabled' id='contact-tab' data-toggle='tab' href='#contact' role='tab' aria-controls='contact' aria-selected='false'>Profesion</a>
								</li>
								<li class='nav-item'>
									<a class='nav-link $disabled' id='personal-tab' data-toggle='tab' href='#personal' role='tab' aria-controls='contact' aria-selected='false'>Datos personales</a>
								</li>
								<li class='nav-item'>
									<a class='nav-link $disabled' id='papeles-tab' data-toggle='tab' href='#papeles' role='tab' aria-controls='papeles' aria-selected='false'>Papeles</a>
								</li>";

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
											echo "<input class='form-control' type='text' id='nombre' NAME='nombre' value='$t_nombre' size='60' maxlength='70' placeholder='Nombre completo'";
											if($db->nivel_personal==0){
											}
											else if($id==1){
												echo  " READONLY ";
											}
											echo  " required autocomplete='OFF'>";

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

										echo  "<div class='col-sm-6'>";
											echo "<label for='presupuestal'>Clave Presupuestal</label>";
											echo "<input class='form-control' type='text' id='presupuestal' NAME='presupuestal' value='$t_clave' maxlength='45' placeholder='Clave presupuestal'>";
										echo "</div>";

										echo  "<div class='col-sm-2'>";
											echo "<label for='cat'>Nivel</label></td>";
											echo  "<select id='cat' name='cat' class='form-control'>";
											echo "<option value='' disabled selected style='color: silver;'>Seleccione...</option>";
											echo  "<option value='A'"; if ($t_categoria=='A') { echo " selected ";} echo ">A</option>";
											echo  "<option value='B'"; if ($t_categoria=='B') { echo " selected ";} echo ">B</option>";
											echo  "<option value='C'"; if ($t_categoria=='C') { echo " selected ";} echo ">C</option>";
											echo  "</select>";
										echo "</div>";

										echo  "<div class='col-sm-4'>";
											echo "<label for='cat1'>Categoria</label>";
											echo "<select id='cat1' name='cat1' class='form-control'>";
											echo "<label for='leyenda'>Nivel de Categoria</label></td>";
											echo "<option value='' disabled selected style='color: silver;'>Seleccione...</option>";
											echo  "<option value='CONTRATO'"; if ($t_categorian=='CONTRATO') { echo " selected ";} echo ">CONTRATO</option>";
											echo  "<option value='BASE'"; if ($t_categorian=='BASE') { echo " selected ";} echo ">BASE</option>";
											echo  "<option value='CONFIANZA'"; if ($t_categorian=='CONFIANZA') { echo " selected ";} echo ">CONFIANZA</option>";
											echo  "<option value='HOMOLOGADO'"; if ($t_categorian=='HOMOLOGADO') { echo " selected ";} echo ">HOMOLOGADO</option>";
											echo  "<option value='PASANTE'"; if ($t_categorian=='PASANTE') { echo " selected ";} echo ">PASANTE</option>";
											echo  "<option value='PLAZA EVENTUAL'"; if ($t_categorian=='PLAZA EVENTUAL') { echo " selected ";} echo ">PLAZA EVENTUAL</option>";
											echo  "<option value='PLAZA RESERVADA'"; if ($t_categorian=='PLAZA RESERVADA') { echo " selected ";} echo ">PLAZA RESERVADA</option>";
											echo  "<option value='PROVISIONAL'"; if ($t_categorian=='PROVISIONAL') { echo " selected ";} echo ">PROVISIONAL</option>";
											echo  "<option value='FORMALIZADO'"; if ($t_categorian=='FORMALIZADO') { echo " selected ";} echo ">FORMALIZADO</option>";
											echo  "<option value='REGULARIZADO'"; if ($t_categorian=='REGULARIZADO') { echo " selected ";} echo ">REGULARIZADO</option>";
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
											echo "<label for='correo'>Nick para el chat:</label>";
											echo "<input type='text' class='form-control' id='nick' name='nick' value='".$t_nick."' size='30' maxlength='45' placeholder='Es para el chat'>";
										echo "</div>";

										echo  "<div class='col-sm-4'>";
											echo "<label for='correo'>Correo:</label>";
											echo "<input type='email' class='form-control' id='correo' name='correo' value='".$t_correo."' placeholder='Correo electrónico válido'>";
										echo "</div>";

										echo  "<div class='col-sm-4'>";
											echo "<label for='correo'>Correo (institucional):</label>";
											echo "<input type='text' class='form-control' id='correoinstitucional' name='correoinstitucional' value='".$t_correoinstitucional."' placeholder='Correo electrelectrónico válido'>";
										echo "</div>";



									echo "</div>";
								echo "</div>";
								echo "<div class='tab-pane fade show' id='home' role='tabpanel' aria-labelledby='home-tab'>";
								/////////////////////////////
									echo "<div class='row'>";
										echo  "<div class='col-sm-5'>";
											echo "<label for='curp'>CURP</label>";
											echo "<input class='form-control' type='text' id='curp' NAME='curp' value='$t_curp' placeholder='CURP'>";
										echo "</div>";

										echo  "<div class='col-sm-3'>";
											echo "<label for='fingreso'>F. Ingreso</label>";
											echo  "<input class='form-control fechaclass' type='text' id='fingreso' NAME='fingreso' value='$fingreso' maxlength='13' placeholder='Fecha'>";
										echo  "</div>";

										echo  "<div class='col-sm-4'>";
											echo "<label for='idpuesto'>Puesto</label>";
											echo "<select class='form-control' name='idpuesto' id='idpuesto'>";
											for($i=0;$i<count($puesto);$i++){
												echo  "<option value='".$puesto[$i]['idpuesto']."'";
												if ($t_idpuesto==$puesto[$i]['idpuesto']){echo  " selected";}
												echo  ">".$puesto[$i]['puesto']."</option>";
											}
											echo  "</select>";
										echo "</div>";
									echo "</div>";

									echo "<div class='row'>";


										echo  "<div class='col-sm-2'>";
											echo "<label for='codigo'>Código</label>";
											echo "<input class='form-control' type='text' id='codigo' NAME='codigo' value='$t_codigo' maxlength='10' placeholder='Código'>";
										echo "</div>";


										$fecha = $fingreso;
										list($anyo,$mes,$dia) = explode("-",$fecha);
										$fingreso=$dia."-".$mes."-".$anyo;



										echo  "<div class='col-sm-3'>";
											echo "<label for='nombra'> Nombramiento</label>";
											echo  "<select class='form-control' class='select' name='nombra' id='nombra' >";
											echo  "<option value='' disabled selected style='color: silver;'>Seleccione...</option>";
											echo  "<option value='BASE'"; if("BASE"==$nombra){ echo " selected ";}echo ">BASE</option>";
											echo  "<option value='BASE (CONFIANZA)'"; if("BASE (CONFIANZA)"==$nombra){ echo " selected ";}echo ">BASE (CONFIANZA)</option>";
											echo  "<option value='CONFIANZA(BASE)'"; if("CONFIANZA(BASE)"==$nombra){ echo " selected ";}echo ">CONFIANZA(BASE)</option>";
											echo  "<option value='CONFIANZA'"; if("CONFIANZA"==$nombra){ echo " selected ";}echo ">CONFIANZA</option>";
											echo  "<option value='CONTRATO'"; if("CONTRATO"==$nombra){ echo " selected ";}echo ">CONTRATO</option>";
											echo  "<option value='COSTO COMPENSADO'"; if("COSTO COMPENSADO"==$nombra){ echo " selected ";}echo ">COSTO COMPENSADO</option>";
											echo  "<option value='HOMOLOGADO'"; if("HOMOLOGADO"==$nombra){ echo " selected ";}echo ">HOMOLOGADO</option>";
											echo  "<option value='HOMOCONFIANZA'"; if("HOMOCONFIANZA"==$nombra){ echo " selected ";}echo ">HOMOLOGADO (CONFIANZA)</option>";
											echo  "<option value='P. RESERVADA (PROVISIONAL)'"; if("P. RESERVADA (PROVISIONAL)"==$nombra){ echo " selected ";}echo ">P. RESERVADA (PROVISIONAL)</option>";
											echo  "<option value='PASANTE'"; if("PASANTE"==$nombra){ echo " selected ";}echo ">PASANTE</option>";
											echo  "<option value='PROVISIONAL'"; if("PROVISIONAL"==$nombra){ echo " selected ";}echo ">PROVISIONAL</option>";
											echo  "<option value='FORMALIZADO'"; if("FORMALIZADO"==$nombra){ echo " selected ";}echo ">FORMALIZADO</option>";
											echo  "<option value='REGULARIZADO'"; if("REGULARIZADO"==$nombra){ echo " selected ";}echo ">REGULARIZADO</option>";
											echo  "</select>";
										echo "</div>";

										echo  "<div class='col-sm-3'>";
											echo  "<label for='idplaza'>T. Plaza</label>";
											echo  "<select name='idplaza' id='idplaza' class='form-control'>";
											echo "<option value='' disabled selected style='color: silver;'>Seleccione...</option>";
											for($i=0;$i<count($plaza);$i++){
												echo  "<option value='".$plaza[$i]['idplaza']."'";
												if ($plaza[$i]['idplaza']==$t_idplaza){
													echo " selected ";
												}
												echo  ">".$plaza[$i]['plaza']."</option>";
											}
											echo  "</select>";
										echo "</div>";

										echo  "<div class='col-sm-4'>";
											echo  "<label for='idprograma'>Programa</label>";
											echo  "<select name='idprograma' id='idprograma' class='form-control'>";
											echo "<option value='' disabled selected style='color: silver;'>Seleccione...</option>";
											for($i=0;$i<count($programa);$i++){
												echo  "<option value='".$programa[$i]['idprogra']."'";
												if ($programa[$i]['idprogra']==$t_idprogra){
													echo  " selected ";
												}
												echo  ">".$programa[$i]['programa']."</option>";
											}
											echo  "</select>";
										echo "</div>";

										echo  "<div class='col-sm-3'>";
											echo "<div class='checkbox'>";
												echo  "<input type='checkbox' name='credencial' id='credencial' value=1";
												if($t_credencial==1){echo " checked";} echo ">";
												echo  "<label for='credencial'>";
												echo  "Credencial institucional (Marcado=si)";
												echo  "</label>";
											echo "</div>";
										echo "</div>";


										echo  "<div class='col-sm-3'>";
											echo "<label for='concepto'>Concepto 07 mensual</label>";
											echo "<input class='form-control' type='text' id='concepto' NAME='concepto' value='$concepto07' maxlength='10' dir='rtl' onKeyPress='return acceptNum(event)'>";
										echo  "</div>";

										echo  "<div class='col-sm-3'>";
											echo "<label for='sueldo'>Sueldo mensual</label>";
											echo "<input class='form-control' type='text' id='sueldo' NAME='sueldo' value='$sueldo' maxlength='10' dir='rtl' onKeyPress='return acceptNum(event)'>";
										echo  "</div>";

										echo "<div class='col-sm-3' style='display:block;'>";
											echo "<label for='compensacion'>Compensación</label>";
											echo "<input class='form-control' type='text' id='compensacion' NAME='compensacion' value='$t_compensa' maxlength='10' dir='rtl' onKeyPress='return acceptNum(event)'>";
										echo  "</div>";





									echo  "</div>";


									echo "<div class='row'>";
										echo  "<div class='col-sm-12'>";
											echo "<label for='observaciones'>Observaciones</label>";
											echo "<input class='form-control' type='text' id='observaciones' NAME='observaciones' value='$t_observa' maxlength='200' placeholder='Observaciones adicionales'>";
										echo  "</div>";
									echo "</div>";
								//////////////////////////////
								echo "</div>";



								echo "<div class='tab-pane fade' id='contact' role='tabpanel' aria-labelledby='contact-tab'>";
									////////////////////////////////////
									echo "<div class='row'>";
										echo  "<div class='col-sm-3'>";
											echo "<label for='horario'>Horario</label>";
											echo "<select class='form-control' name='horario' id='horario' >;";
											echo "<option value='' disabled selected style='color: silver;'>Seleccione...</option>";
											echo  "<option ";if ($t_horario==1){echo  " selected "; }echo  "value=1>Matutino</option>";
											echo  "<option ";if ($t_horario==2){echo  " selected "; }echo  "value=2>Vespertino</option>";
											echo  "<option ";if ($t_horario==3){echo  " selected "; }echo  "value=3>Velada A</option>";
											echo  "<option ";if ($t_horario==4){echo  " selected "; }echo  "value=4>Velada B</option>";
											echo  "<option ";if ($t_horario==5){echo  " selected "; }echo  "value=5>Especial diurno</option>";
											echo  "<option ";if ($t_horario==6){echo  " selected "; }echo  "value=6>Especial nocturno</option>";
											echo  "<option ";if ($t_horario==7){echo  " selected "; }echo  "value=7>Acumulado A</option>";
											echo  "<option ";if ($t_horario==8){echo  " selected "; }echo  "value=8>Acumulado B</option>";
											echo  "<option ";if ($t_horario==9){echo  " selected "; }echo  "value=9>Cubreincidencias</option>";
											echo  "<option ";if ($t_horario==10){echo  " selected "; }echo  "value=10>Mixto</option>";
											echo  "</select></td>";
										echo "</div>";

										echo  "<div class='col-sm-3'>";
											echo "<label for='lunes'>Lunes</label>";
											echo "<input class='form-control' type='text' id='lunes' NAME='lunes' value='".$t_lunes."' maxlength='200' placeholder='Horario'>";
										echo "</div>";

										echo  "<div class='col-sm-3'>";
											echo "<label for='martes'>Martes</label>";
											echo "<input class='form-control' type='text' id='martes' NAME='martes' value='".$t_martes."' maxlength='200' placeholder='Horario'>";
										echo "</div>";

										echo  "<div class='col-sm-3'>";
											echo "<label for='miercoles'>Miercoles</label>";
											echo "<input class='form-control' type='text' id='miercoles' NAME='miercoles' value='".$t_miercoles."' maxlength='200' placeholder='Horario'>";
										echo "</div>";

										echo  "<div class='col-sm-3'>";
											echo "<label for='jueves'>Jueves</label>";
											echo "<input class='form-control' type='text' id='jueves' NAME='jueves' value='".$t_jueves."' maxlength='200' placeholder='Horario'>";
										echo "</div>";

										echo  "<div class='col-sm-3'>";
											echo "<label for='viernes'>Viernes</label>";
											echo "<input class='form-control' type='text' id='viernes' NAME='viernes' value='".$t_viernes."' maxlength='200' placeholder='Horario'>";
										echo "</div>";

										echo  "<div class='col-sm-3'>";
											echo "<label for='sabado'>Sabado</label>";
											echo "<input class='form-control' type='text' id='sabado' NAME='sabado' value='".$t_sabado."' maxlength='200' placeholder='Horario'>";
										echo "</div>";


										echo  "<div class='col-sm-3'>";
											echo "<label for='idprofesion'>Profesión</label>";
											echo "<select class='form-control' name='idprofesion' id='idprofesion' >";
											echo "<option value='' disabled selected style='color: silver;'>Seleccione...</option>";
											for($i=0;$i<count($profesion);$i++){
												echo  "<option value='".$profesion[$i]['idprofesion']."'";
												if ($idprofesion==$profesion[$i]['idprofesion']){echo  " selected";}
												echo  ">".$profesion[$i]['profesion']."</option>";
											}
											echo  "</select>";
										echo "</div>";

										echo  "<div class='col-sm-3'>";
											echo "<label for='idescolaridad'>Escolaridad</label>";
											echo "<select class='form-control' name='idescolaridad' id='idescolaridad' >";
											echo "<option value='' disabled selected style='color: silver;'>Seleccione...</option>";
											for($i=0;$i<count($escolaridad);$i++){
												echo  "<option value='".$escolaridad[$i]['idescolaridad']."'";
												if ($idescolaridad==$escolaridad[$i]['idescolaridad']){echo  " selected";}
												echo  ">".$escolaridad[$i]['escolaridad']."</option>";
											}
											echo  "</select>";
										echo "</div>";

										echo  "<div class='col-sm-3'>";
											echo "<label for='idacredita'>Acredita con</label>";
											echo "<select class='form-control' name='idacredita' id='idacredita'>";
											echo "<option value='' disabled selected style='color: silver;'>Seleccione...</option>";
											for($i=0;$i<count($listado_acredita);$i++){
												echo  "<option value='".$listado_acredita[$i]['idacredita']."'";
												if ($idacredita==$listado_acredita[$i]['idacredita']){echo  " selected";}
												echo  ">".$listado_acredita[$i]['acredita']."</option>";
											}
											echo  "</select>";
										echo "</div>";

										echo  "<div class='col-sm-3'>";
										echo "<label for='idespecialidad'>Especialidad Médica</label>";
											echo "<select class='form-control' name='idespecialidad' id='idespecialidad'>";
											echo "<option value='' disabled selected style='color: silver;'>Seleccione...</option>";
											for($i=0;$i<count($listado_esp);$i++){
												echo  "<option value='".$listado_esp[$i]['idespecialidad']."'";
												if ($idespecialidad==$listado_esp[$i]['idespecialidad']){echo  " selected";}
												echo  ">".$listado_esp[$i]['especialidad']."</option>";
											}
											echo  "</select>";
										echo "</div>";

										echo  "<div class='col-sm-3'>";
											echo "<label for='idespecialidad'> No. Cédula Profesional</label>";
											echo "<input class='form-control' type='text' id='cedula' NAME='cedula' value='".$t_cedula."' maxlength='13' placeholder='Ingresar no. Cedula'>";
										echo "</div>";


										echo  "<div class='col-sm-3'>";
											echo "<label for='idfuncion'>Función</label>";
												echo "<select class='form-control' name='idfuncion' id='idfuncion'>";
												echo "<option value='' disabled selected style='color: silver;'>Seleccione...</option>";
												for($i=0;$i<count($personal_fun);$i++){
													echo  "<option value='".$personal_fun[$i]['idfuncion']."'";
													if ($idfuncion==$personal_fun[$i]['idfuncion']){echo  " selected";}
													echo  ">".$personal_fun[$i]['funcion']."</option>";
												}
												echo  "</select>";
										echo "</div>";

									echo "</div>";
									/////////////////////////////////////
								echo "</div>";

								echo "<div class='tab-pane fade' id='personal' role='tabpanel' aria-labelledby='personal-tab'>";
									////////////////////////////////////////////
									echo "<div class='row'>";
										echo  "<div class='col-sm-4'>";
											echo "<label for='calle'>Calle</label>";
											echo "<input class='form-control' type='text' id='calle' NAME='calle' value='".$t_calle."' maxlength='200' placeholder='Dirección personal'>";
										echo "</div>";

										echo  "<div class='col-sm-2'>";
											echo "<label for='num'> No</label>";
											echo "<input class='form-control' type='text' id='num' NAME='num' value='".$t_numero."' maxlength='10' placeholder='No.'>";
										echo "</div>";

										echo  "<div class='col-sm-4'>";
											echo "<label for='colonia'>Colonia</label>";
											echo "<input class='form-control' type='text' id='colonia' NAME='colonia' value='".$t_colonia."' maxlength='50' placeholder='Colonia'>";
										echo "</div>";

										echo  "<div class='col-sm-2'>";
											echo "<label for='cpostal'>Código postal</label>";
											echo "<input class='form-control' type='text' id='cpostal' NAME='cpostal' value='".$t_cpostal."' maxlength='200' placeholder='CP'>";
										echo "</div>";

										echo  "<div class='col-sm-3'>";
											echo "<label for='estado'>Estado</label>";
											echo "<input class='form-control' type='text' id='estado' NAME='estado' value='".$t_estado."' maxlength='200' placeholder='Estado'>";
										echo "</div>";

										echo  "<div class='col-sm-3'>";
											echo "<label for='municipio'>Municipio</label>";
											echo "<input class='form-control' type='text' id='municipio' NAME='municipio' value='".$t_municipio."' maxlength='200' placeholder='Municipio'>";
										echo "</div>";

										echo  "<div class='col-sm-2'>";
											echo "<label for='telefono'>Tel. casa</label>";
											echo "<input class='form-control' type='text' id='telefono' NAME='telefono' value='".$t_telefono."' maxlength='45' placeholder='Telefono'>";
										echo "</div>";

										echo  "<div class='col-sm-2'>";
											echo "<label for='telcel'>Tel. Celular</label>";
											echo "<input class='form-control' type='text' id='telcel' NAME='telcel' value='".$t_telcel."' size='10' maxlength='45' placeholder='Tel. Celular'>";
										echo "</div>";

										echo  "<div class='col-sm-2'>";
											echo "<label for='directorio'>Tel. oficina</label>";
											echo "<input class='form-control' type='text' id='directorio' NAME='directorio' value='".$t_directorio."' size='10' maxlength='45' placeholder='Extension o telefono directo'>";
										echo "</div>";

										echo  "<div class='col-sm-4'>";
											echo "<label for='sangre'>Grupo sanguineo</label>";
											echo "<select class='form-control' name='sangre' id='sangre'>;";
											echo "<option value='' disabled selected style='color: silver;'>Seleccione...</option>";
											echo  "<option ";if ($t_grupo_sanguineo=="A Rh(+)"){echo  " selected "; }echo  "value='A Rh(+)'>A Rh(+)</option>";
											echo  "<option ";if ($t_grupo_sanguineo=="A Rh(-)"){echo  " selected "; }echo  "value='A Rh(-)'>A Rh(-)</option>";
											echo  "<option ";if ($t_grupo_sanguineo=="B Rh(+)"){echo  " selected "; }echo  "value='B Rh(+)'>B Rh(+)</option>";
											echo  "<option ";if ($t_grupo_sanguineo=="B Rh(-)"){echo  " selected "; }echo  "value='B Rh(-)'>B Rh(-)</option>";
											echo  "<option ";if ($t_grupo_sanguineo=="O Rh(+)"){echo  " selected "; }echo  "value='O Rh(+)'>O Rh(+)</option>";
											echo  "<option ";if ($t_grupo_sanguineo=="O Rh(-)"){echo  " selected "; }echo  "value='O Rh(-)'>O Rh(-)</option>";
											echo  "<option ";if ($t_grupo_sanguineo=="AB Rh(+)"){echo  " selected "; }echo  "value='AB Rh(+)'>AB Rh(+)</option>";
											echo  "<option ";if ($t_grupo_sanguineo=="AB Rh(-)"){echo  " selected "; }echo  "value='AB Rh(-)'>AB Rh(-)</option>";
											echo  "</select>";
										echo "</div>";

										echo  "<div class='col-sm-2'>";
											echo "<div class='checkbox'>";
												echo  "<input type='checkbox' name='mama' id='mama' value=1";
												if($t_mama==1){echo " checked";} echo ">";
												echo  "<label for='mama'><br>";
												echo  " Madre";
												echo  "</label>";
											echo "</div>";
										echo "</div>";

										echo  "<div class='col-sm-2'>";
											echo "<div class='checkbox'>";
												echo  "<input type='checkbox' name='papa' id='papa' value=1";
												if($t_papa==1){echo " checked";} echo ">";
												echo  "<label for='papa'><br>";
												echo  " Padré";
												echo  "</label>";
											echo "</div>";
										echo "</div>";


										echo  "<div class='col-sm-2'>";
											echo "<div class='checkbox'>";
												echo  "<input type='checkbox' name='hijos' id='hijos' value=1";
												if($t_hijos==1){echo " checked";} echo ">";
												echo  "<label for='hijos'><br>";
												echo  " Hijo <12 años?";
												echo  "</label>";
											echo "</div>";
										echo "</div>";

										echo  "<div class='col-sm-3'>";
											echo "<label for='fecha_hijo'>F. nacimiento hijo (a)</label>";
											echo  "<input class='form-control fechaclass' type='text' id='fecha_hijo' NAME='fecha_hijo' value='$t_fecha_hijo' maxlength='13' placeholder='Fecha'>";
										echo  "</div>";

									echo "</div>";
									////////////////////////////////////////////
								echo "</div>";

								echo "<div class='tab-pane fade' id='papeles' role='tabpanel' aria-labelledby='papeles-tab'>";
									echo "<div class='baguetteBoxOne gallery'>";
									if(count($personal_doc)>0){
										for($i=0;$i<count($personal_doc);$i++){
											echo "<div style='border:0;float:left;margin:10px;'>";

											$dir = str_replace("$db->doc", "", $personal_doc[$i]['direccion']);
											$info = new SplFileInfo("../".$personal_doc[$i]['direccion']);

												echo "<a href='$db->doc".trim($personal_doc[$i]['direccion'])."' data-caption='Correspondencia' target='_blank'>";
												if($info->getExtension()=="pdf"){
													echo "<img src='../img/pdf.png' alt='Correspondencia' >";
												}
												else{
													echo "<img src='$db->doc".trim($personal_doc[$i]['direccion'])."' alt='Correspondencia' >";
												}
												echo "</a>";

											echo "<br><button class='btn btn-outline-secondary btn-sm' title='Eliminar archivo' type='button'
											id='delfile_documento".$personal_doc[$i]['iddocumento']."'
											data-ruta='".$db->doc.trim($personal_doc[$i]['direccion'])."'
											data-keyt='iddocumento'
											data-key='".$personal_doc[$i]['iddocumento']."'
											data-tabla='personal_docu'
											data-campo='direccion'
											data-tipo='2'
											data-iddest='$id'
											data-divdest='trabajo'
											data-borrafile='1'
											data-dest='a_personal/editar.php?id='
											><i class='far fa-trash-alt'></i></button>";
											echo "</div>";
										}
									}
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
					echo "<button type='button' class='btn btn-outline-secondary btn-sm' data-toggle='modal' data-target='#myModal' id='fileup_documento' data-ruta='$db->doc' data-tabla='personal_docu' data-campo='direccion' data-tipo='2' data-id='$id' data-keyt='idpersona' data-destino='a_personal/editar' data-iddest='$id' data-ext='.jpg,.png' title='Subir documento'><i class='fas fa-cloud-upload-alt'></i>Documentos</button>";
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
