<?php
ob_start(); // Inicia el buffer de salida
require "./inc/session_start.php";?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "./inc/head.php";?>
</head>

<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Confirmación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      <div class="modal-body">
        ¿Estás seguro de que quieres enviar el formulario?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="cancelButton" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="acceptButton">Aceptar</button>
      </div>
    </div>
  </div>
</div>


<body>
    <?php

        if(!isset($_GET['vista']) || $_GET['vista']==""){
            $_GET['vista']="login";
        }

        if(is_file("./vistas/".$_GET['vista'].".php") && $_GET['vista']
        !="login" && $_GET['vista']!="404"){
          # Cerrar la sesion forzadamente #
          if((!isset($_SESSION['id']) || $_SESSION['id']=="") || (!isset
          ($_SESSION['usuario']) || $_SESSION['usuario']=="")){ //Si la variable de sesion $_SESSION['id'] no viene definida o está vacia ingrese en el if
            
              include "logout.php";
              exit();
          }

            include "./inc/navbar.php";
            include "./inc/sidebar.php";
            include "./vistas/".$_GET['vista'].".php";
            include "./inc/script.php";
        }else{
            if($_GET['vista']=="login"){
                include "./vistas/login.php";
            }else{
                include "./vistas/404.php";
            }
        }



    ?>
    
</body>
</html>
<?php
ob_end_flush(); // Envía el contenido del buffer de salida y desactiva el almacenamiento en búfer
?>
