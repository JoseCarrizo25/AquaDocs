<?php
session_name("IV");
session_start();

// Destruir todas las variables de sesión
session_unset(); 

// Destruir la sesión
session_destroy(); 

// Redirigir al usuario a la página de login
header("Location: index.php?vista=login");
exit;
?>
