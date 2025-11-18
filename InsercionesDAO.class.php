<?php
require_once "Conexion.class.php";
require_once "Usuario.class.php";
class InsercionesDAO{
    public static function registrarUsuarrio($nombre, $apellidos, $edad, $email, $contraseña){
        $conexion = Conexion::getInstancia()->getConexion();
        $insercion = "INSERT INTO usuarios VALUES (?,?,?,?,?)";
        $resultado = $conexion->prepare($insercion);
        $resultado->execute([$nombre,$apellidos,$edad,$email,$contraseña]);
    }
}
?>