<?php
require_once "Conexion.class.php";
require_once "Usuario.class.php";
class InsercionesDAO{
    public static function registrarUsuario($nombre, $apellidos, $edad, $email, $contraseña){
        try{
            $conexion = Conexion::getInstancia()->getConexion();
            $insercion = "INSERT INTO usuarios (nombre, apellidos, edad, email, contraseña) VALUES (?, ?, ?, ?, ?)";
            $resultado = $conexion->prepare($insercion);
            $exito = $resultado->execute([$nombre, $apellidos, $edad, $email, $contraseña]);
            
            return $exito;
        }catch(PDOException $e){
            return false;
        }
    }
    
    public static function verificarEmailExistente($email){
        try{
            $conexion = Conexion::getInstancia()->getConexion();
            $consulta = "SELECT COUNT(*) FROM usuarios WHERE email = ?";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute([$email]);
            return $resultado->fetchColumn() > 0;
            
        }catch(PDOException $e){
            return false; 
        }
    }
}
?>