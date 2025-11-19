<?php 
require_once "insercionesDAO.class.php";
$errores = array();
$mensaje_exito = '';
$nombre = $apellidos = $edad = $email = '';

//Proceso para el formulario
 if (isset($_POST['registro'])) {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $edad = trim($_POST['edad']);
    $email = trim($_POST['email']);
    $contrasena = $_POST['contrasena'];
    $contrasena2 = $_POST['contrasena2'];
    
    if ($contrasena !== $contrasena2) {
        $errores[] = "Las contraseñas no coinciden.";
    }
    if (empty($errores)) {
        if (InsercionesDAO::verificarEmailExistente($email)) {
            $errores[] = "El correo electrónico **$email** ya se encuentra registrado. Por favor, utilice otro.";
        }
        if (empty($errores)) {
            $resultado = InsercionesDAO::registrarUsuario($nombre, $apellidos, $edad, $email, $contrasena);
            if ($resultado) {
                $mensaje_exito = "¡El registro se ha completado con éxito!";
                $nombre = $apellidos = $edad = $email = ''; 
            } else {
                $errores[] = "Fallo en el registro. Hubo un error desconocido en la base de datos.";
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de usuarios</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <div class="contenedor">
        <div class="registro">
            <h3>Registro de usuarios</h3>
            
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
            
            <form action="registro.php" method="POST">
                <div class="campos">
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre" required value="<?php echo htmlspecialchars($nombre ?? ''); ?>">
                </div>
                <div class="campos">
                    <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" required value="<?php echo htmlspecialchars($apellidos ?? ''); ?>">
                </div>
                <div class="campos">
                    <input type="number" id="edad" name="edad" placeholder="Edad" required value="<?php echo htmlspecialchars($edad ?? ''); ?>">
                </div>
                <div class="campos">
                    <input type="email" id="email" name="email" placeholder="Email" required value="<?php echo htmlspecialchars($email ?? ''); ?>">
                </div>
                <div class="campos">
                    <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                </div>

                <div class="campos">
                    <input type="password" id="contrasena2" name="contrasena2" placeholder="Repita la contraseña" required>
                </div>

                <button type="submit" name="registro" id="registro">Registrar</button>
            </form>
            
            <p class="footer">© I.E.S. Monte Naranco</p>
        </div>
    </div>
</body>
</html>