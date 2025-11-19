<?php
require_once "parque.class.php";
require_once "restaurante.class.php";
require_once "zonaPublica.class.php";
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

    public static function getAtracciones()
    {
        try {
            $conexion = Conexion::getInstancia()->getConexion();

            $consulta = "SELECT
                    a.*,
                    a.id AS atraccionId,
                    a.nombre AS atraccionNombre,
                    a.descripcion AS atraccionDescripcion,
                    pa.id AS parqueId,
                    pa.nombre AS parqueNombre,
                    pa.descripcion AS parqueDescripcion
                FROM atracciones a
                JOIN parque_atracciones pa ON a.parque_id = pa.id";

            $resultado = $conexion->prepare($consulta);
             $resultado->execute();

            $atracciones = [];

            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                $parque = new Parque(
                    $fila['parqueId'],
                    $fila['parqueNombre'],
                    $fila['parqueDescripcion']
                );

                $atraccion = new Atraccion(
                    $fila['atraccionId'],
                    $parque,
                    $fila['atraccionNombre'],
                    $fila['atraccionDescripcion'],
                    $fila['edad_minima']
                );

                $atracciones[] = $atraccion;
            }

            return $atracciones;
        } catch (PDOException $e) {
            return false;
        }
    }


    public static function getRestaurantes()
    {
        try {
            $conexion = Conexion::getInstancia()->getConexion();
            $consulta = "SELECT
                        r.id AS restauranteId,
                        r.nombre AS restauranteNombre,
                        r.descripcion as restauranteDescripcion,
                        r.tipo_cocina, 
                        pa.id,
                        pa.nombre ,
                        pa.descripcion 
                    FROM restaurantes r 
                    JOIN parque_atracciones pa ON r.parque_id = pa.id;
";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $restaurantes = [];

            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
               $parque = new Parque(
                    $fila['id'],
                    $fila['nombre'],
                    $fila['descripcion']
                );

                 $restaurante = new Restaurante(
                    $fila['restauranteId'],
                    $parque,
                    $fila['restauranteNombre'],
                    $fila['restauranteDescripcion'],
                    $fila['tipo_cocina']
                );

                $restaurantes[] = $restaurante;
            }

            return $restaurantes;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getZonas()
    {
        try {
            $conexion = Conexion::getInstancia()->getConexion();
            $consulta = "SELECT
                        zp.id AS zonasId,
                        zp.nombre AS rzonasNombre,
                        zp.descripcion as zonasDescripcion,
                        pa.id,
                        pa.nombre ,
                        pa.descripcion 
                    FROM zonas_publicas zp 
                    JOIN parque_atracciones pa ON zp.parque_id = pa.id;";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $zonas[] = [];

            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                $parque = new Parque(
                    $fila['id'],
                    $fila['nombre'],
                    $fila['descripcion']
                );

                $zona = new ZonaPublica(
                    $fila['zonasId'],
                    $parque,
                    $fila['zonasNombre'],
                    $fila['rzonasDescripcion']
                    
                );

                $zonas[] = $zona;
            }

            return $zonas;
        } catch (PDOException $e) {
            return false;
        }
    }
}
