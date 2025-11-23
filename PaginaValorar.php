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
function get_parque_slug_by_id(int $parque_id): string {
    $mapeo = [
        1 => 'warner',
        2 => 'parque_atracciones_madrid',
        3 => 'porta_aventura',
    ];
    return $mapeo[$parque_id] ?? 'parque_desconocido'; 
}


$parque_id = filter_input(INPUT_POST, 'parque_id', FILTER_VALIDATE_INT) ?? filter_input(INPUT_GET, 'parque_id', FILTER_VALIDATE_INT);
$parque_nombre = "Parque Desconocido";

$parque_slug = get_parque_slug_by_id($parque_id);
$parque_obj = ParquesDAO::getParquePorId($parque_id);
if ($parque_obj && $parque_obj->getNombre()) {
    $parque_nombre = $parque_obj->getNombre();
}

$restaurantes_todos = ConsultasDAO::getRestaurantesPorParque($parque_id); 
$atracciones_todas = ParquesDAO::getAtracciones($parque_id);
$zonas_todas = ParquesDAO::getZonas($parque_id);
$mensaje_exito = '';
$errores = [];
$usuario_id = isset($_SESSION['usuario']) ? $_SESSION['usuario']->getIdUsuario() : null; 

$restaurantes_pendientes = [];
$atracciones_pendientes = [];
$zonas_pendientes = [];

if (!$usuario_id) {
    $errores[] = "Error de sesión: No se pudo identificar al usuario. Por favor, inicie sesión de nuevo.";
} else {
    foreach ($restaurantes_todos as $restaurante) {
        if (!ConsultasDAO::yaHaValorado($usuario_id, $restaurante->getId(), 'restaurante')) {
            $restaurantes_pendientes[] = $restaurante;
        }
    }
    foreach ($atracciones_todas as $atraccion) {
        if (!ConsultasDAO::yaHaValorado($usuario_id, $atraccion->getId(), 'atraccion')) {
            $atracciones_pendientes[] = $atraccion;
        }
    }
    foreach ($zonas_todas as $zona) {
        if (!ConsultasDAO::yaHaValorado($usuario_id, $zona->getId(), 'zona_publica')) {
            $zonas_pendientes[] = $zona;
        }
    }

    $elementos_a_valorar_pendientes = [
        'restaurante' => $restaurantes_pendientes,
        'atraccion' => $atracciones_pendientes,
        'zona_publica' => $zonas_pendientes, 
    ];
}

$total_pendientes = count($restaurantes_pendientes) + count($atracciones_pendientes) + count($zonas_pendientes);
if ($total_pendientes === 0 && !isset($_GET['success'])) {
    header("Location: MostrarParques.php?message=ParqueCompleto&parque_id=" . $parque_id);
    exit;
}

if (isset($_POST['enviar_valoraciones'])) {
    
    if (empty($errores)) {
        $puntuaciones = $_POST['puntuacion'] ?? [];
        $comentarios = $_POST['comentario'] ?? [];
        
        $todas_valoradas = true; 
        foreach ($elementos_a_valorar_pendientes as $tipo => $elementos) {
            foreach ($elementos as $elemento) {
                $elemento_id = $elemento->getId();
                $clave_form = $tipo . '_' . $elemento_id;
                
                $puntuacion = filter_var($puntuaciones[$clave_form] ?? null, FILTER_VALIDATE_INT);
                $comentario = trim($comentarios[$clave_form] ?? '');

                if ($puntuacion === false || $puntuacion < 0 || $puntuacion > 5 || empty($comentario)) {
                    $errores[] = "Falta valorar el elemento: " . htmlspecialchars($elemento->getNombre()) . 
                                 " ($tipo). La puntuación y el comentario son obligatorios.";
                    $todas_valoradas = false;
                    break 2;
                }
            }
        }

        if ($todas_valoradas && empty($errores)) {
            
            $exitosos = 0;
            
            foreach ($elementos_a_valorar_pendientes as $tipo => $elementos) {
                foreach ($elementos as $elemento) {
                    $elemento_id = $elemento->getId();
                    $clave_form = $tipo . '_' . $elemento_id;
                    
                    $puntuacion = filter_var($puntuaciones[$clave_form], FILTER_VALIDATE_INT);
                    $comentario = $comentarios[$clave_form];
                    
                    $exito_insercion = InsercionesDAO::valoracion(
                        $usuario_id, 
                        $elemento_id, 
                        $tipo, 
                        $puntuacion, 
                        $comentario
                    );
                    
                    if ($exito_insercion) {
                        $exitosos++;
                    } else {
                        $errores[] = "Error al guardar la valoración de " . htmlspecialchars($elemento->getNombre()) . ".";
                    }
                }
            }

            if ($exitosos > 0 && empty($errores)) {
                header("Location: PaginaValorar.php?parque_id=" . $parque_id . "&success=" . $exitosos);
                exit;
            }
        }
    }
}

if (isset($_GET['success'])) {
     $mensaje_exito = "¡Felicidades! Se han enviado " . (int)$_GET['success'] . " valoraciones exitosamente.";
}

$restaurantes = $restaurantes_pendientes; 
$atracciones = $atracciones_pendientes;
$zonas = $zonas_pendientes;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valorar Elementos - <?php echo htmlspecialchars($parque_nombre); ?></title>
    <link rel="stylesheet" href="css/estilosValorar.css"> 
</head>
<body>
   <div class="cabecera-principal">
        <div>
            <a href="MostrarParques.php">Volver atrás</a>
            <a href="CerrarSesion.php" class="btn-cerrar-sesion">Cerrar Sesión</a>
        </div>
    </div>
    
    <div class="contenedor-valoracion">
        <?php if (!empty($mensaje_exito)): ?>
            <div class="mensaje-exito">✅ <?php echo htmlspecialchars($mensaje_exito); ?></div>
        <?php endif; ?>
        <?php if (!empty($errores)): ?>
            <div class="mensaje-error">
                <h3>🚨 Se requiere corregir lo siguiente para poder enviar la valoración:</h3>
                <ul>
                    <?php foreach ($errores as $error) { echo "<li>" . htmlspecialchars($error) . "</li>"; } ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if ($total_pendientes > 0): ?>
        
        <form action="PaginaValorar.php" method="post">
            <input type="hidden" name="parque_id" value="<?php echo htmlspecialchars($parque_id); ?>">

            <div class="grupo-cards">
                <h2>🍔 Restaurantes Pendientes de Valorar</h2>
                <div class="card-grid">
                    <?php if (is_array($restaurantes) && !empty($restaurantes)): ?>
                        <?php foreach ($restaurantes as $restaurante): ?>
                            <?php 
                                $id = $restaurante->getId();
                                $name_base = 'restaurante_' . $id;
                                $puntuacion_actual = $_POST['puntuacion'][$name_base] ?? '';
                                $comentario_actual = $_POST['comentario'][$name_base] ?? '';
                                // RUTA DE IMAGEN
                                $ruta_imagen = 'img/parques/' . $parque_slug . '/restaurantes/' . htmlspecialchars($restaurante->getImagen());
                            ?>
                            <div class="card">
                                <h4><?php echo htmlspecialchars($restaurante->getNombre()); ?></h4>
                                <div class="imagen-elemento">
                                    <img src="<?php echo $ruta_imagen; ?>" alt="Imagen de <?php echo htmlspecialchars($restaurante->getNombre()); ?>">
                                </div>
                                <label for="puntuacion_<?php echo $name_base; ?>">Puntuación (0-5):</label>
                                <select name="puntuacion[<?php echo $name_base; ?>]" 
                                        id="puntuacion_<?php echo $name_base; ?>" required>
                                    <option value="" disabled selected>Puntuación</option>
                                    <?php for ($i = 0; $i <= 5; $i++): ?>
                                        <option value="<?php echo $i; ?>" 
                                                <?php echo ($puntuacion_actual !== '' && (int)$puntuacion_actual === $i) ? 'selected' : ''; ?>>
                                            <?php echo $i; ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                       
                                <label for="comentario_<?php echo $name_base; ?>">Comentario:</label>
                                <textarea name="comentario[<?php echo $name_base; ?>]" 
                                          id="comentario_<?php echo $name_base; ?>" 
                                          required><?php echo htmlspecialchars($comentario_actual); ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No tienes restaurantes pendientes de valorar.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="grupo-cards">
                <h2>🎢 Atracciones Pendientes de Valorar</h2>
                <div class="card-grid">
                    <?php if (is_array($atracciones) && !empty($atracciones)): ?>
                        <?php foreach ($atracciones as $atraccion): ?>
                            <?php 
                                $id = $atraccion->getId();
                                $name_base = 'atraccion_' . $id;
                                $puntuacion_actual = $_POST['puntuacion'][$name_base] ?? '';
                                $comentario_actual = $_POST['comentario'][$name_base] ?? '';
                                // RUTA DE IMAGEN
                                $ruta_imagen = 'img/parques/' . $parque_slug . '/atracciones/' . htmlspecialchars($atraccion->getImagen());
                            ?>
                            <div class="card">
                                <h4><?php echo htmlspecialchars($atraccion->getNombre()); ?></h4>
                                <div class="imagen-elemento">
                                    <img src="<?php echo $ruta_imagen; ?>" alt="Imagen de <?php echo htmlspecialchars($atraccion->getNombre()); ?>">
                                </div>
                                <label for="puntuacion_<?php echo $name_base; ?>">Puntuación (0-5):</label>
                                <select name="puntuacion[<?php echo $name_base; ?>]" 
                                        id="puntuacion_<?php echo $name_base; ?>" required>
                                    <option value="" disabled selected>Puntuación</option>
                                    <?php for ($i = 0; $i <= 5; $i++): ?>
                                        <option value="<?php echo $i; ?>" 
                                                <?php echo ($puntuacion_actual !== '' && (int)$puntuacion_actual === $i) ? 'selected' : ''; ?>>
                                            <?php echo $i; ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                       
                                <label for="comentario_<?php echo $name_base; ?>">Comentario:</label>
                                <textarea name="comentario[<?php echo $name_base; ?>]" 
                                          id="comentario_<?php echo $name_base; ?>" 
                                          required><?php echo htmlspecialchars($comentario_actual); ?>
                                </textarea>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No tienes atracciones pendientes de valorar.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="grupo-cards">
                <h2>🌳 Zonas Públicas Pendientes de Valorar</h2>
                <div class="card-grid">
                    <?php if (is_array($zonas) && !empty($zonas)): ?>
                        <?php foreach ($zonas as $zona): ?>
                            <?php 
                                $id = $zona->getId();
                                $name_base = 'zona_publica_' . $id;
                                $puntuacion_actual = $_POST['puntuacion'][$name_base] ?? '';
                                $comentario_actual = $_POST['comentario'][$name_base] ?? '';
                                // RUTA DE IMAGEN
                                $ruta_imagen = 'img/parques/' . $parque_slug . '/zonas_publicas/' . htmlspecialchars($zona->getImagen());
                            ?>
                            <div class="card">
                                <h4><?php echo htmlspecialchars($zona->getNombre()); ?></h4>
                                <div class="imagen-elemento">
                                    <img src="<?php echo $ruta_imagen; ?>" alt="Imagen de <?php echo htmlspecialchars($zona->getNombre()); ?>">
                                </div>
                                <label for="puntuacion_<?php echo $name_base; ?>">Puntuación (0-5):</label>
                                <select name="puntuacion[<?php echo $name_base; ?>]" 
                                        id="puntuacion_<?php echo $name_base; ?>" required>
                                    <option value="" disabled selected>Puntuación</option>
                                    <?php for ($i = 0; $i <= 5; $i++): ?>
                                        <option value="<?php echo $i; ?>" 
                                                <?php echo ($puntuacion_actual !== '' && (int)$puntuacion_actual === $i) ? 'selected' : ''; ?>>
                                            <?php echo $i; ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                       
                                <label for="comentario_<?php echo $name_base; ?>">Comentario:</label>
                                <textarea name="comentario[<?php echo $name_base; ?>]"  id="comentario_<?php echo $name_base; ?>" 
                                          required><?php echo htmlspecialchars($comentario_actual); ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No tienes zonas públicas pendientes de valorar.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="submit-section">
                <button type="submit" name="enviar_valoraciones" class="btn-enviar">Enviar Todas las Valoraciones Pendientes</button>
            </div>
        </form>
        
        <?php else: ?>
             <div class="mensaje-exito">
                 <h3>🎉 ¡Felicidades! Has valorado todos los elementos pendientes de este parque.</h3>
             </div>
             <div class="submit-section">
                 <button type="button" class="btn-enviar" disabled>No hay elementos pendientes de valorar</button>
             </div>
        <?php endif; ?>
        
    </div>
</body>
</html>