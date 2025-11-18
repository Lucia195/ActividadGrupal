<?php
// Incluye tu archivo de conexión a la base de datos aquí si es necesario
// include 'conexion.php'; 

$errores = array(); // Inicializa el array de errores
$mensaje_exito = '';

// 1. Procesamiento del formulario
/* if (isset($_POST['registro'])) {
    
    $nombre = trim($_POST['nombre']);
    $contrasena = $_POST['contrasena'];
    $contrasena2 = $_POST['contrasena2'];
    
    // 2. Validación
    if (empty($nombre) || empty($contrasena) || empty($contrasena2)) {
        $errores[] = "Todos los campos son obligatorios.";
    }

    if ($contrasena !== $contrasena2) {
        $errores[] = "Las contraseñas no coinciden.";
    }
    
    // 3. Registro (Si no hay errores)
    if (empty($errores)) {
        
        // Aquí se ejecutaría la lógica de registro en la base de datos
        // $pass_hash = password_hash($contrasena, PASSWORD_DEFAULT);
        // Lógica: INSERT INTO usuarios ...
        
        $mensaje_exito = "¡Registro exitoso! (Añade código de base de datos real)";
    }
} */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <div class="contenedor">
        <div class="registro">
            <h3>Inicio de sesión</h3>
            
            <?php 
            if (!empty($errores)) {
            ?>
                <div class="mensaje-error">
                <?php 
                    foreach ($errores as $error) {
                        echo "<p style='margin: 0;'>$error</p>";
                    }
                ?>
                </div>
            <?php 
            }
            ?>

            <?php 
            if (!empty($mensaje_exito)) {
            ?>
                <div class="mensaje-exito">
                    <p style='margin: 0;'><?php echo $mensaje_exito; ?></p>
                </div>
            <?php 
            }
            ?>
            
            <form action="inicio.php" method="POST">
                <div class="campos">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="campos">
                    <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                </div>
                <button type="submit" name="inicio" id="inicio">Registrar</button>
            </form>
            
            <p class="footer">© I.E.S. Monte Naranco</p>
        </div>
    </div>

</body>
</html>