<?php
require_once "Conexion.class.php";
require_once "Usuario.class.php";
class ConsultasDAO{
    public static function inicioSesion($email, $contrasena){
        try{
            $conexion = Conexion::getInstancia()->getConexion();
            $consulta = "SELECT * FROM usuarios WHERE email=? and contraseña=?";
            $resultado = $conexion->prepare($consulta);
            $resultado = $resultado->execute([$email, $contrasena]); 
            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)){
                $usuario = new Usuario($fila['id'], $fila['nombre'], $fila['apellidos'], $fila['edad'], $fila['email'], $fila['contraseña']);
            }
            return $usuario;
        }catch (PDOException $e){
            return false;
        }
    }
}
?>