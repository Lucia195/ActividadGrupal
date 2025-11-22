<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "ParquesDAO.class.php";
require_once "ConsultasDAO.class.php";
require_once "Restaurante.class.php";
require_once "ParqueAtracciones.class.php";
require_once "InsercionesDAO.class.php";
require_once "Usuario.class.php";

session_start();


//Recuperamos el id y el tipo de manera segura
$parque_id = filter_input(INPUT_POST, 'parque_id', FILTER_VALIDATE_INT);
$parque_nombre = "Parque Desconocido";
$parque_obj = ParquesDAO::getParquePorId($parque_id);
if ($parque_obj && $parque_obj->getNombre()) {
    $parque_nombre = $parque_obj->getNombre();
}

//Obtenemos solo los restaurantes del parque
$restaurantes = ConsultasDAO::getRestaurantesPorParque($parque_id); 
$mensaje_exito = '';
$errores = [];

if (isset($_POST['valoracion_restaurante'])) {
    $usuario_id = $_SESSION['usuario']->getIdUsuario() ?? null;
    $exito = InsercionesDAO::valoracion($usuario_id, $_POST['restaurante_id'], "restaurante", $_POST['puntuacion'], $_POST['comentario']);
}

if (isset($_POST['valoracion-atraccion'])) {
    //Esto no está funcionando, pendiente para arreglar
    $usuario_id = $_SESSION['usuario']->getIdUsuario() ?? null;
    $exito = InsercionesDAO::valoracion($usuario_id, $_POST['atraccion_id'], "atraccion", $_POST['puntuacion-atraccion'], $_POST['comentario-atraccion']);
}
if (isset($_POST['valoracion-zona'])) {
    //Esto no está funcionando, pendiente para arreglar
    $usuario_id = $_SESSION['usuario']->getIdUsuario() ?? null;
    $exito = InsercionesDAO::valoracion($usuario_id, $_POST['zona_publica_id'], "zona_publica", $_POST['puntuacion-zona'], $_POST['comentario-zona']);
}

$atracciones = ParquesDAO::getAtracciones($parque_id);

$zonas = ParquesDAO::getZonas($parque_id);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valorar Restaurantes - <?php echo htmlspecialchars($parque_nombre); ?></title>
    <link rel="stylesheet" href="css/estilosValorar.css"> <!--Falta aplicar los estilos a los formularios-->
</head>
<body>
    <div class="cabecera-principal">
        <a href="CerrarSesion.php" class="btn-cerrar-sesion">Cerrar Sesión</a>
        <a href="MostrarParques.php">Volver atrás</a>
    </div>
    <div class="contenedorFormularios">
        <!--Formulario para valorar los restaurantes-->
        <form action="PaginaValorar.php" method="post">
            <label for="restaurante_id">Seleccionar Restaurante:</label>
            <select name="restaurante_id" id="restaurante_id" required>
                <option value="">-- Elige un restaurante --</option>
                <?php 
                $restaurante_seleccionado = $_POST['restaurante_id'] ?? null;

                if (is_array($restaurantes) && !empty($restaurantes)) {
                    foreach ($restaurantes as $restaurante) {
                        $selected_attr = ($restaurante_seleccionado == $restaurante->getId()) ? ' selected' : '';
                        echo "<option value=\"" . htmlspecialchars($restaurante->getId()) . "\"" . $selected_attr . ">";
                        echo htmlspecialchars($restaurante->getNombre());
                        echo "</option>";

                    }
                } else {
                    echo "<option value='' disabled>No se encontraron restaurantes para este parque.</option>";
                }
                ?>
            </select>
            <label for="puntuacion">Puntuacion:</label>
            <input type="number" name="puntuacion" id="puntuacion" required min="0" max="5" step="1" value="<?php echo htmlspecialchars($puntuacion_seleccionada); ?>"placeholder="Introduce un número del 0 al 5">
            <label for="comentario">Descripcion:</label>
            <textarea name="comentario" id="comentario" required></textarea>
            <input type="hidden" name="parque_id" value="<?php echo htmlspecialchars($parque_id); ?>">
            <button type="submit" name="valoracion_restaurante" id="valoracion_restaurante">Enviar valoracion</button>
        </form>

        <!--Formulario para valorar las atracciones-->
        <form action="PaginaValorar.php" method="post">
            <label for="atraccion_id">Seleccionar Atraccion:</label>
            <select name="atraccion_id" id="atraccion_id" required>
                <option value="">-- Elige una atraccion --</option>
                <?php 
                $atraccionSeleccionada = $_POST['atraccion_id'] ?? null;

                if (is_array($atracciones) && !empty($atracciones)) {
                    foreach ($atracciones as $atraccion) {
                        $selected_attr = ($atraccionSeleccionada == $atraccion->getId()) ? ' selected' : '';
                        echo "<option value=\"" . htmlspecialchars($atraccion->getId()) . "\"" . $selected_attr . ">";
                        echo htmlspecialchars($atraccion->getNombre());
                        echo "</option>";

                    }
                } else {
                    echo "<option value='' disabled>No se encontraron atracciones para este parque.</option>";
                }
                ?>
            </select>
            <label for="puntuacion-atraccion">Puntuacion:</label>
            <input type="number" name="puntuacion-atraccion" id="puntuacion-atraccion" required min="0" max="5" step="1" value="<?php echo htmlspecialchars($puntuacion_seleccionada); ?>"placeholder="Introduce un número del 0 al 5">
            <label for="comentario-atraccion">Descripcion:</label>
            <textarea name="comentario-atraccion" id="comentario-atraccion"></textarea>
            <input type="hidden" name="parque_id" value="<?php echo htmlspecialchars($parque_id); ?>">
            <button type="submit" name="valoracion-atraccion" id="valoracion-atraccion">Enviar valoracion</button>
        </form>

        <!--Formulario para valorar Zona Publica-->
        <form action="PaginaValorar.php" method="post">
            <label for="zona_publica_id">Seleccionar Zona Pública:</label>
            <select name="zona_publica_id" id="zona_publica_id" required>
                <option value="">-- Elige una zona publica --</option>
                <?php 
                $zonaSeleccionada = $_POST['zona_publica_id'] ?? null;

                if (is_array($zonas) && !empty($zonas)) {
                    foreach ($zonas as $zona) {
                        $selected_attr = ($zonaSeleccionada == $zona->getId()) ? ' selected' : '';
                        echo "<option value=\"" . htmlspecialchars($zona->getId()) . "\"" . $selected_attr . ">";
                        echo htmlspecialchars($zona->getNombre());
                        echo "</option>";

                    }
                } else {
                    echo "<option value='' disabled>No se encontraron atracciones para este parque.</option>";
                }
                ?>
            </select>
            <label for="puntuacion-zona">Puntuacion:</label>
            <input type="number" name="puntuacion-zona" id="puntuacion-zona" required min="0" max="5" step="1" value="<?php echo htmlspecialchars($puntuacion_seleccionada); ?>"placeholder="Introduce un número del 0 al 5">
            <label for="comentario-zona">Descripcion:</label>
            <textarea name="comentario-zona" id="comentario-zona"></textarea>
            <input type="hidden" name="parque_id" value="<?php echo htmlspecialchars($parque_id); ?>">
            <button type="submit" name="valoracion-zona" id="valoracion-zona">Enviar valoracion</button>
        </form>
    </div>
</body>
</html>