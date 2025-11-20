<?php
require_once "Conexion.class.php";
require_once "ParqueAtracciones.class.php";
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
                $parques[] = new ParqueAtracciones(
                    $fila['id'],
                    $fila['nombre'],
                    $fila['descripcion'],
                    $fila['parque_imagen']
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
                    a.id AS atraccionId,
                    a.nombre AS atraccionNombre,
                    a.descripcion AS atraccionDescripcion,
                    a.atraccion_imagen AS atraccionImagen,
                    pa.id AS parqueId,
                    pa.nombre AS parqueNombre,
                    pa.descripcion AS parqueDescripcion,
                    pa.parque_imagen AS parqueImagen
                FROM atracciones a
                JOIN parque_atracciones pa ON a.parque_id = pa.id";

            $resultado = $conexion->prepare($consulta);
             $resultado->execute();

            $atracciones = [];

            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                $parque = new ParqueAtracciones(
                    $fila['parqueId'],
                    $fila['parqueNombre'],
                    $fila['parqueDescripcion'],
                    $fila['parqueImagen']
                );

                $atraccion = new Atraccion(
                    $fila['atraccionId'],
                    $parque,
                    $fila['atraccionNombre'],
                    $fila['atraccionDescripcion'],
                    $fila['edad_minima'],
                    $fila['atraccionImagen']
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
                        r.restaurante_imagen, 
                        pa.id,
                        pa.nombre ,
                        pa.descripcion,
                        pa.parque_imagen
                    FROM restaurantes r 
                    JOIN parque_atracciones pa ON r.parque_id = pa.id;";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

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

    public static function getZonas()
    {
        try {
            $conexion = Conexion::getInstancia()->getConexion();
            $consulta = "SELECT
                        zp.id AS zonasId,
                        zp.nombre AS rzonasNombre,
                        zp.descripcion as zonasDescripcion,
                        zp.zona_publica_imagen,
                        pa.id,
                        pa.nombre ,
                        pa.descripcion,
                        pa.parque_imagen
                    FROM zonas_publicas zp 
                    JOIN parque_atracciones pa ON zp.parque_id = pa.id;";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $zonas[] = [];

            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                $parque = new ParqueAtracciones(
                    $fila['id'],
                    $fila['nombre'],
                    $fila['descripcion'],
                    $fila['parque_imagen']
                );

                $zona = new ZonaPublica(
                    $fila['zonasId'],
                    $parque,
                    $fila['zonasNombre'],
                    $fila['rzonasDescripcion'],
                    $fila['zona_publica_imagen']
                    
                );

                $zonas[] = $zona;
            }

            return $zonas;
        } catch (PDOException $e) {
            return false;
        }
    }
    public static function getParquePorId(int $id): ?ParqueAtracciones{
        try {
            $conexion = Conexion::getInstancia()->getConexion();
            $consulta = "SELECT id, nombre, descripcion, imagen FROM parque_atracciones WHERE id = ?"; 
            $resultado = $conexion->prepare($consulta);
            $resultado->execute([$id]);

            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            if ($fila) {
                return new ParqueAtracciones(
                    $fila['id'],
                    $fila['nombre'],
                    $fila['descripcion'],
                    $fila['imagen']
                );
            }

            return null; 
        } catch (PDOException $e) {
            return null;
        }
    }
}
?>