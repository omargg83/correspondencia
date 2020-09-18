<?php
  require_once("../control_db.php");
?>
<nav class='navbar navbar-expand-sm navbar-dark fixed-top principal_menu'>

  <img src='img/escudo.png' width='40' height='30' alt=''>
  <img src='img/SSH.png' width='40' height='30' alt=''>
  <a class='navbar-brand' href='#escritorio/dashboard' style='font-size:10px'>Sistema Administrativo de Salud Pública</a>

  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#principal' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
    <i class='fab fa-rocketchat'></i>
  </button>

  <div class='collapse navbar-collapse' id='principal'>
    <ul class='navbar-nav mr-auto'>
      <li class='nav-item dropdown'>
        <a class='nav-link navbar-brand' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'></a>
      </li>
    </ul>
    <ul class='nav navbar-nav navbar-right' id='notificaciones'></ul>

    <ul class='nav navbar-nav navbar-right' id='chatx'>
      <li class='nav-item dropdown'>
         <a class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
          <i class='fab fa-rocketchat fa-spin' style='color:#96ff57 !important;'></i> Chat
         </a>

         <div id='myUL' class='dropdown-menu' aria-labelledby='navbarDropdown' style='width:200px;max-height:400px !important; overflow: scroll; overflow-x: hidden;'>
        <div class='row'><div class='col-12'><input type='text' id='myInput' placeholder='Buscar..' title='Buscar' class='form-control' autocomplete='off'></div></div>
          <div id='conecta_x'>
          </div>
         </div>
       </li>
    </ul>

    <ul class='nav navbar-nav navbar-right' id='fondo'></ul>
    <ul class='nav navbar-nav navbar-right'>
      <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
          <?php
            if (file_exists('a_archivos/personal/'.trim($_SESSION['foto']))){
            echo "<img src='a_archivos/personal/".trim($_SESSION['foto'])."' class='rounded-circle' width='20px' height='20px'>";
            }
            else{
              echo "<img src='a_personal/Screenshot_1.png' alt='Cuenta' class='rounded-circle' width='20px' height='20px'>";
            }
            echo $_SESSION['nick'];
          ?>
        </a>
        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
          <a class='dropdown-item' id='winmodal_pass' data-id='<?php echo $_SESSION['idpersona']; ?>' data-lugar='a_personal/form_pass' title='Cambiar contraseña' ><i class='fas fa-key'></i>Contraseña</a>
          <?php
            if($_SESSION['administrador']==1){
              echo "<a class='dropdown-item' id='winmodal_pass' data-id='".$_SESSION['idpersona']."' data-lugar='a_personal/form_pass' title='Cambiar contraseña' ><i class='fas fa-key'></i>Usuario</a>";
            }
          ?>
        </div>
      </li>
    </ul>
    <ul class='nav navbar-nav navbar-right'>
      <li class='nav-item'>
        <a class='nav-link pull-left' onclick='salir()'>
          <i class='fas fa-door-open' style='color:red;'></i>Salir
        </a>
      </li>
    </ul>
  </div>
</nav>
