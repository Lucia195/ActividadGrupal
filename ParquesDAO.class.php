<?php
require_once "Conexion.class.php";
require_once "ParqueAtracciones.class.php";
require_once "Atraccion.class.php";
require_once "ZonaPublica.class.php";
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

     public static function getAtracciones($idParque)
    {
        try {
            $conexion = Conexion::getInstancia()->getConexion();

            $consulta = "SELECT
                    a.id AS atraccionId,
                    a.nombre AS atraccionNombre,
                    a.descripcion AS atraccionDescripcion,
                    a.edad_minima AS edadMinima,
                    a.atraccion_imagen AS atraccionImagen,
                    pa.id AS parqueId,
                    pa.nombre AS parqueNombre,
                    pa.descripcion AS parqueDescripcion,
                    pa.parque_imagen AS parqueImagen
                FROM atracciones a
                JOIN parque_atracciones pa ON a.parque_id = pa.id
                WHERE a.parque_id=?";

            $resultado = $conexion->prepare($consulta);
            $resultado->execute([$idParque]);

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
                    $fila['edadMinima'],
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

    public static function getZonas($idParque)
    {
        try {
            $conexion = Conexion::getInstancia()->getConexion();

            $consulta = "SELECT
                            zp.id AS zonasId,
                            zp.nombre AS zonasNombre,
                            zp.descripcion as zonasDescripcion,
                            zp.zona_publica_imagen,
                            pa.id,
                            pa.nombre,
                            pa.descripcion,
                            pa.parque_imagen
                        FROM zonas_publicas zp 
                        JOIN parque_atracciones pa ON zp.parque_id = pa.id
                        WHERE zp.parque_id = ?";

            $resultado = $conexion->prepare($consulta);
            $resultado->execute([$idParque]);

            $zonas = [];

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
                    $fila['zonasDescripcion'],
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

    public static function mostrarValoracion(int $id){
    $consulta = "SELECT p.id AS parque_id, p.nombre AS parque,
                        AVG(v.puntuacion) AS valoracion_media
                 FROM parque_atracciones p
                 LEFT JOIN valoraciones v
                 ON (
                     (v.valorable_tipo = 'parque' AND v.valorable_id = p.id) 
                     OR (v.valorable_tipo = 'zona_publica' AND v.valorable_id IN (
                         SELECT id FROM zonas_publicas WHERE parque_id = p.id
                     )) 
                     OR (v.valorable_tipo = 'atraccion' AND v.valorable_id IN (
                         SELECT id FROM atracciones WHERE parque_id = p.id
                     )) 
                     OR (v.valorable_tipo = 'restaurante' AND v.valorable_id IN (
                         SELECT id FROM restaurantes WHERE parque_id = p.id
                     ))
                 )
                 WHERE p.id = ?
                 GROUP BY p.id, p.nombre";
    try {
        $conexion = Conexion::getInstancia()->getConexion();
        $resultado = $conexion->prepare($consulta);
        $resultado->execute([$id]);

        $fila = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($fila && $fila['valoracion_media'] !== null) {
            // Redondeamos la valoración a 2 decimales
            return round(floatval($fila['valoracion_media']), 2);
        } else {
            return 0; // Si no hay valoraciones, devolver 0
        }
    } catch (PDOException $e) {
        // Opcional: podrías registrar el error con $e->getMessage()
        return 0;
    }
}
}
?>