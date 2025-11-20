<?php 
require_once "ParqueAtracciones.class.php";
require_once "ParquesDAO.class.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atracciones del Parque</title>
    
    <link rel="stylesheet" href="css/estilosMostrar.css">
    
</head>

<body>
    <div class="cabecera-principal">
        <h1>Lista de parques de atracciones</h1>
        <a href="CerrarSesion.php" class="btn-cerrar-sesion">Cerrar Sesión</a>
    </div>
    <div class="contenedor-parques">

        <?php
        $lista = ParquesDAO::getParqueAtracciones();
        foreach ($lista as $p) {
            $id = $p->getId();
            $nombre = $p->getNombre();
            $descripcion = $p->getDescripcion();
            $imagen = $p->getImagen();
            echo '
            <div class="parque">
                
                <div class="contenido">
                    <h3>' . htmlspecialchars($nombre) . '</h3>
                    <p>' . htmlspecialchars($descripcion) . '</p>
                    <div><img src="' . $imagen . '" alt=""></div>
                    <form action="" method="POST">
                        <input type="hidden" name="parque_id" value="' . htmlspecialchars($id) . '">
                        <input type="hidden" name="tipo_valoracion" value="atraccion">
                        <button type="submit" name="valorarAtracciones" id="valorarAtracciones" class="btn-valoracion">Valorar atracciones</button>
                    </form>
                    <form action="PaginaValorarRestaurante.php" method="POST">
                        <input type="hidden" name="parque_id" value="' . htmlspecialchars($id) . '">
                        <input type="hidden" name="tipo_valoracion" value="restaurante">
                        <button type="submit" name="valorarRestaurantes" id="valorarRestaurantes" class="btn-valoracion">Valorar restaurantes</button>
                    </form>
                    <form action="" method="POST">
                        <input type="hidden" name="parque_id" value="' . htmlspecialchars($id) . '">
                        <input type="hidden" name="tipo_valoracion" value="zona_publica">
                        <button type="submit" name="valorarZonasPublicas" id="valorarZonasPublicas" class="btn-valoracion">Valorar zonas publicas</button>
                    </form>
                </div>
            </div>
            ';
            }
        ?>
    </div>

</body>

</html>