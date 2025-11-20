<?php
require_once "ParquesDAO.class.php";
require_once "ConsultasDAO.class.php";
require_once "Restaurante.class.php";
require_once "ParqueAtracciones.class.php";
session_start();

//Recuperamos el id y el tipo de manera segura
$parque_id = filter_input(INPUT_POST, 'parque_id', FILTER_VALIDATE_INT);
$tipo_valoracion = filter_input(INPUT_POST, 'tipo_valoracion', FILTER_SANITIZE_SPECIAL_CHARS);
$parque_nombre = "Parque Desconocido";
$parque_obj = ParquesDAO::getParquePorId($parque_id);
if ($parque_obj && $parque_obj->getNombre()) {
    $parque_nombre = $parque_obj->getNombre();
}

//Obtenemos solo los restaurantes del parque
$restaurantes = ConsultasDAO::getRestaurantesPorParque($parque_id); 
$mensaje_exito = '';
$errores = [];

if (isset($_POST['valorar_restaurante'])) {

}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valorar Restaurantes - <?php echo htmlspecialchars($parque_nombre); ?></title>
    <link rel="stylesheet" href="css/estilosValorar.css"> 
</head>
<body>
    <form action="PaginaValorarRestaurante.php" method="post">
        <label for="restaurante_id">Seleccionar Restaurante:</label>
        <select name="restaurante_id" id="restaurante_id" required>
            <option value="">-- Elige un restaurante --</option>
            <?php 
            $restaurante_seleccionado = $_POST['restaurante_id'] ?? null;
            
            if (is_array($restaurantes) && !empty($restaurantes)) {
                foreach ($restaurantes as $restaurante) {
                    // 1. Obtener el atributo 'selected' si aplica
                    $selected_attr = ($restaurante_seleccionado == $restaurante->getId()) ? ' selected' : '';

                    // 2. Imprimir la etiqueta <option> completa
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
        <textarea name="comentario" id="comentario"></textarea>
    </form>
</body>
</html>