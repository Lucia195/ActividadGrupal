<?php
session_start();
//Eliminar todas las variables de sesión
session_unset(); 
//Se destruye la sesion
session_destroy(); 
header("Location: inicio.php"); 
exit(); 
?>