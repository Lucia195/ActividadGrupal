<?php
require_once "Conexion.class.php";
class ConsultasDAO{
    public static function comprobarContraseña($email, $contrasena){
        try{
            $conexion = Conexion::getInstancia()->getConexion();
            $consulta = "SELECT * FROM usuarios WHERE email=? and contraseña=?";
            $resultado = $conexion->prepare($consulta);
            $exito = $resultado->execute([$email, $contrasena]); 
            return $exito;
        }catch (PDOException $e){
            return false;
        }
    }
}
?>