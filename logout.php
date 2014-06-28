<?php
session_start();
unset($_SESSION['nick']);
unset($_SESSION['rol']);
unset($_SESSION['id_rol']);
unset($_SESSION['id_usuario']);
session_unset();
session_destroy(); // destruyo la sesión 
header("Location: index.php"); //envío al usuario a la pag. de autenticación 
?>
