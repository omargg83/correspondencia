<?php
	require_once("../control_db.php");
  $db = new Salud();
?>
        <div class='sidebar' id='navx'>

          <a href='#dash/dashboard' class='activeside'><i class='fas fa-home'></i><span>Inicio</span></a>
          <a href='#a_personal/index' title='Plantilla de personal'><i class='fas fa-users '></i> <span>Personal</span></a>
          <a href='#a_orga/index' title='Organigrama'><i class='fas fa-sitemap'></i><span>Organigrama</span></a>
          <a href='#a_comision/index' title='Oficios de comisión'><i class='fas fa-clipboard'></i> <span>Comisión</span></a>
          <a href='#a_corresp/index' title='Correspondencia de entrada' ><i class='fas fa-arrow-circle-down'></i> <span>Entrada</span></a>
          <a href='#a_corresps/index' title='Correspondencia de salida'> <i class='fas fa-arrow-circle-up'></i> <span>Salida</span></a>

          <?php

          if(array_key_exists('CORRESPREGISTRO', $db->derecho) and $db->derecho['CORRESPREGISTRO']['acceso']==1)
          echo "<a href='#a_correspr/index' title='Registro'><i class='far fa-registered'></i><span>Registro</span></a>";

          if(array_key_exists('CHEQUES', $db->derecho) and $db->derecho['CHEQUES']['acceso']==1)
          echo "<a href='#a_cheques/index' title='Cheques'><i class='fas fa-money-bill-alt'></i><span>Cheques</span></a>";

          if(array_key_exists('SALIDAS', $db->derecho) and $db->derecho['SALIDAS']['acceso']==1)
          echo "<a href='#a_salidas/index' title='Calendario de salidas'><i class='fas fa-bus'></i><span>Salidas</span></a>";

          echo "<a href='#a_inventario/index' title='Inventario'><i class='fas fa-desktop'></i><span>Inventario</span></a>";

          if(array_key_exists('PAPELERIA', $db->derecho) and $db->derecho['PAPELERIA']['acceso']==1)
          echo "<a href='#a_papeleria/index' title='Cheques'><i class='fas fa-boxes'></i><span>Papeleria</span></a>";


          //if(array_key_exists('COMITES', $db->derecho) and $db->derecho['COMITES']['acceso']==1)
          echo "<a href='#a_comite/index' title='Comités'><i class='fas fa-people-carry'></i><span>Comités</span></a>";

          echo "<a href='#a_presupuesto/index' title='Cheques'><i class='fas fa-hand-holding-usd'></i><span>Presupuesto</span></a>";

          echo "<a id='winmodal_pass' data-lugar='dash/anio' title='Cambiar contraseña' ><i class='fas fa-key'></i><span>Año</span></a>";

          $admin=0;
          if($_SESSION['administrador']==1){
            $admin=1;
            echo "<a href='#a_encuesta/index' title='Encuesta'><i class='fas fa-person-booth'></i><span>Encuesta</span></a>";
            echo "<a href='#a_directorio/index' title='Directorio'><i class='far fa-address-book'></i><span>Directorio</span></a>";
            echo "<hr>";
            echo "<a href='#a_registro/index' title='registro'><i class='fas fa-money-bill-alt'></i><span>Registro</span></a>";
            echo "<a href='#a_sistema/inicio' title='Mantenimiento'><i class='fas fa-money-bill-alt'></i><span>Mantenimiento</span></a>";
            echo "<a href='#a_oficios/index' title='Oficios'><i class='fas fa-money-bill-alt'></i><span>oficios</span></a>";
            echo "<a href='#a_encuestaform/index' title='Oficios'><i class='fas fa-money-bill-alt'></i><span>Encuesta</span></a>";
          }
        ?>
        </div>
