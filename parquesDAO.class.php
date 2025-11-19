<?php
require_once "parque.class.php";
require_once "conexion.class.php";

class ParquesDAO
{
    public static function getParqueAtracciones()
    {
        try {
            $conexion = Conexion::getInstancia()->getConexion();
            $consulta = "SELECT * FROM parque_atracciones";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $parques = [];

            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                $parques[] = new Parque(
                    $fila['id'],
                    $fila['nombre'],
                    $fila['descripcion']
                );
            }

            return $parques;
            
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getAtraccionesPorId(int $parqueId)
    {
        try {
            $conexion = Conexion::getInstancia()->getConexion();
            $consulta = "SELECT * FROM parque_atracciones";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $parques = [];

            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                $parques[] = new Parque(
                    $fila['id'],
                    $fila['nombre'],
                    $fila['descripcion']
                );
            }

            return $parques;
            
        } catch (PDOException $e) {
            return false;
        }
    }


     public static function getRestaurantesPorId(int $parqueId)
    {
        try {
            $conexion = Conexion::getInstancia()->getConexion();
            $consulta = "SELECT * FROM parque_atracciones";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $parques = [];

            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                $parques[] = new Parque(
                    $fila['id'],
                    $fila['nombre'],
                    $fila['descripcion']
                );
            }

            return $parques;
            
        } catch (PDOException $e) {
            return false;
        }
    }


     public static function getZonasPorId(int $id)
    {
        try {
            $conexion = Conexion::getInstancia()->getConexion();
            $consulta = "SELECT * FROM parque_atracciones";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $parques = [];

            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                $parques[] = new Parque(
                    $fila['id'],
                    $fila['nombre'],
                    $fila['descripcion']
                );
            }

            return $parques;
            
        } catch (PDOException $e) {
            return false;
        }
    }
}
