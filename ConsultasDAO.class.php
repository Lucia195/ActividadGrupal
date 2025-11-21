<?php
require_once "Conexion.class.php";
require_once "Usuario.class.php";
class ConsultasDAO{
    public static function inicioSesion($email, $contrasena) :  ?Usuario{
        try{
            $conexion = Conexion::getInstancia()->getConexion();
            $consulta = "SELECT id, nombre, apellidos, edad, email, contraseña FROM usuarios WHERE email=? AND contraseña=?";
            $statement = $conexion->prepare($consulta);
            if (!$statement->execute([$email, $contrasena])) {
                 return null; 
            }
            $fila = $statement->fetch(PDO::FETCH_ASSOC);

            if ($fila) {
                return new Usuario($fila['id'], $fila['nombre'], $fila['apellidos'], $fila['edad'], $fila['email'], null);
            } else {
                return null;
            }
        }catch (PDOException $e){
            return null;
        }
    }
    public static function getRestaurantesPorParque(int $parqueId) {
        try {
            $conexion = Conexion::getInstancia()->getConexion();
            $consulta = "SELECT
                        r.id AS restauranteId,
                        r.nombre AS restauranteNombre,
                        r.descripcion AS restauranteDescripcion,
                        r.tipo_cocina,
                        r.restaurante_imagen, 
                        pa.id,
                        pa.nombre ,
                        pa.descripcion,
                        pa.parque_imagen
                    FROM restaurantes r 
                    JOIN parque_atracciones pa ON r.parque_id = pa.id
                    WHERE r.parque_id = ?;";
                    
            $resultado = $conexion->prepare($consulta);
            $resultado->execute([$parqueId]);
            $restaurantes = [];
            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
               $parque = new ParqueAtracciones(
                    $fila['id'],
                    $fila['nombre'],
                    $fila['descripcion'],
                    $fila['parque_imagen']
                );

                 $restaurante = new Restaurante(
                    $fila['restauranteId'],
                    $parque,
                    $fila['restauranteNombre'],
                    $fila['restauranteDescripcion'],
                    $fila['tipo_cocina'],
                    $fila['restaurante_imagen']
                );

                $restaurantes[] = $restaurante;
            }

            return $restaurantes;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>