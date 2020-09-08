<?php
  require_once("db_.php");
  $pd= $db->reporte();
  echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
 	echo "<br><h5>Oficios</h5>";
 	echo "<hr>";
 ?>
 		<div class="content table-responsive table-full-width" >
 			<table id='x_lista' class='display compact' style='font-size:8pt;'>
 			<thead>
        <!--
 			<th>#</th>
 			<th>idcentro</th>
 			<th>idoficio</th>
    -->
 			<th>Interno</th>
 			<th>Oficio</th>
 			<th>Remitente</th>
 			<th>Dependencia</th>
 			<th>Nombre</th>
 			<th>Area</th>
 			<th>Fecha recibido</th>
 			<th>Fecha captura</th>
 			<th>Fecha Modificado</th>
 			<!--<th>Diferencia</th>-->
 			<th>H. Diferencia <br>Recibido : Captura</th>
 			<th>Fecha turno</th>
      <th>Fecha firma</th>
      <!--<th>Diferencia</th>-->
 			<th>H. Diferencia <br>Turnado : Firma</th>
 			<th>Fecha respuesta</th>
      <th>H. Diferencia <br>Firma : Respuesta</th>

      <th> Acumulado Captura - Firma</th>
      <th> Acumulado Captura - Respuesta</th>
 			</tr>
 			</thead>
 			<tbody>
 			<?php
 				if (count($pd)>0){
          $primero=0;
          $uno_x=0;
 					foreach($pd as $key){

            if($primero!=$key['idoficio']){
              $primero=$key['idoficio'];
              $uno_x=0;
            }
            /*
 						echo "<td>";
 							echo "<div class='btn-group'>";
 								echo "<button class='btn btn-outline-secondary btn-sm' id='edit_comision' title='Editar' data-lugar='a_comision/editar'><i class='fas fa-pencil-alt'></i></i></button>";
 								echo "<button class='btn btn-outline-secondary btn-sm' id='eliminar_comision' data-lugar='a_comision/db_' data-destino='a_comision/lista' data-id='".$key['idcomision']."' data-funcion='borrar_oficio' data-div='trabajo'><i class='far fa-trash-alt'></i></i></button>";

 								echo "<button class='btn btn-outline-secondary btn-sm' id='imprimir_comision' title='Imprimir' data-lugar='a_comision/imprimir' data-tipo='1'><i class='fas fa-print'></i></button>";
 							echo "</div>";
 						echo "</td>";
            */

 						//echo "<td>".$key["idcentro"]."</td>";
 						//echo "<td>".$key["idoficio"]."</td>";

            $uno_x++;
            $bgcolor="";
            if($uno_x==1) $bgcolor="yellow";
            echo "<tr id='".$key['idoficio']."' class='edit-t'>";
            echo "<td>";
            echo $key["numero"];
            echo "</td>";

 						echo "<td>";
              echo $key["numoficio"];
            echo "</td>";

 						echo "<td>";
              echo $key["remitente"];
            echo "</td>";

 						echo "<td>";
            echo $key["dependencia"];
            echo "</td>";

 						echo "<td bgcolor='$bgcolor'>".$key["nombre"]."</td>";
 						echo "<td>".$key["area"]."</td>";

              echo "<td bgcolor='#a9dbb8'>";
              echo $key["frecibido"];
              echo "</td>";

 						echo "<td bgcolor='#a9dbb8'>".$key["fcaptura"]."</td>";
            echo "<td bgcolor='#a9dbb8'>".$key["modificado"]."</td>";

            $frecibido = new DateTime($key["frecibido"]);
            $fcaptura = new DateTime($key["fcaptura"]);
            $fechturnado = new DateTime($key["fechturnado"]);
            $f_irma = new DateTime($key["f_irma"]);
            $fcontesta = new DateTime($key["fcontesta"]);
            $modificado = new DateTime($key["modificado"]);

            /*
 						echo "<td>";
              echo $intervalo->format('%Y - %m - %d %H : %i : %s');
            echo "</td>";
            */

            ////////////////////////
            $intervalo = $f_irma->diff($modificado);
            $dif=($intervalo->days * 24 ) + ( $intervalo->h) ;
            echo "<td>";
            if(strlen($key["modificado"])>0){
              echo $dif.":".$intervalo->i.":".$intervalo->s."<br>";
            }
            echo "</td>";

            echo "<td bgcolor='silver'>".$key["fechturnado"]."</td>";
            echo "<td bgcolor='silver'> ".$key["f_irma"]."</td>";

            $intervalo = $f_irma->diff($fechturnado);
            $dif=($intervalo->days * 24 ) + ( $intervalo->h) ;
 						echo "<td>";
            if(strlen($key["f_irma"])>0){
              echo $dif.":".$intervalo->i.":".$intervalo->s."<br>";
            }
            echo "</td>";

 						echo "<td bgcolor='silver'>".$key["fcontesta"]."</td>";
            $intervalo = $fcontesta->diff($f_irma);
            $dif=($intervalo->days * 24 ) + ( $intervalo->h) ;

            echo "<td>";
            if(strlen($key["fcontesta"])>0){
              echo $dif.":".$intervalo->i.":".$intervalo->s."<br>";
            }
            echo "</td>";

            $intervalo = $fcaptura->diff($f_irma);
            $dif=($intervalo->days * 24 ) + ( $intervalo->h) ;
            echo "<td>";
            if(strlen($key["f_irma"])>0){
              echo $dif.":".$intervalo->i.":".$intervalo->s."<br>";
            }
            echo "</td>";

            $intervalo = $fcaptura->diff($fcontesta);
            $dif=($intervalo->days * 24 ) + ( $intervalo->h) ;
            echo "<td>";
            if(strlen($key["fcontesta"])>0){
              echo $dif.":".$intervalo->i.":".$intervalo->s."<br>";
            }
            echo "</td>";
 						echo "</tr>";
 					}
 				}
 			?>
 			</tbody>
 			</table>
 		</div>
 	</div>

 <script>
 	$(document).ready( function () {
 		lista("x_lista");
 	} );
 </script>
