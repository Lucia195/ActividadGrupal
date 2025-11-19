<?php
require_once "ConsultasDAO.class.php";
session_start();
$errores = '';
$mensaje_exito = '';


if ($_POST['inicio']){
    $correo=trim($_POST['email']);
    $contrasena=trim($_POST['contrasena']);
    $resultado = ConsultasDAO::comprobarContraseña($correo, $contrasena);
    if (!$resultado){
        $errores = "La contraseña y el correo no coinciden";
    }else{
        //Falta llevar a la pagina de la lista de los parques
        $_SESSION['correo'] = $correo;//Para que se mantenga la sesión iniciada
    }

}
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
            <?php //Se muestra el mensaje si la contraseña o el correo no concuerdan
            if (!empty($errores)){
                echo "<div class='mensaje-error'>";
                echo "<p style='margin: 0;'>$errores</p>";
            }
            ?>

            <form action="inicio.php" method="POST">
                <div class="campos">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="campos">
                    <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                </div>
                <button type="submit" name="inicio" id="inicio">Iniciar Sesion</button>
            </form>
            
            <p class="footer">© I.E.S. Monte Naranco</p>
        </div>
    </div>
    <div class="pie-login">
        <p>Si no tienes cuenta:</p>
        <form action="registro.php" method="post">
            <button type="submit" class="boton-registro">Registrarse</button>
        </form>
    </div>
</body>
</html>