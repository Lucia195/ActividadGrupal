<?php
require_once "Conexion.class.php";
require_once "Usuario.class.php";
class ConsultasDAO{
    public static function inicioSesion($email, $contrasena){
        try{
            $conexion = Conexion::getInstancia()->getConexion();
            $consulta = "SELECT id, nombre, apellidos, edad, email, contraseña FROM usuarios WHERE email=? AND contraseña=?";
            $statement = $conexion->prepare($consulta);
            if (!$statement->execute([$email, $contrasena])) {
                 return false; 
            }
            $fila = $statement->fetch(PDO::FETCH_ASSOC);

            if ($fila) {
                return new Usuario($fila['id'], $fila['nombre'], $fila['apellidos'], $fila['edad'], $fila['email'], $fila['contraseña']);
            } else {
                return false;
            }
        }catch (PDOException $e){
            return false;
        }
    }
}
?>