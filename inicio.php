<?php
require_once "ConsultasDAO.class.php";
session_start();
$errores = '';
$mensaje_exito = '';


if (isset($_POST['inicio'])){
    $correo=trim($_POST['email']);
    $contrasena=trim($_POST['contrasena']);
    $resultado = ConsultasDAO::inicioSesion($correo, $contrasena);
    if (!$resultado){
        $errores = "La contraseña y el correo son incorrectos";
    }else{
        //Guardar el usuario directamente sin la contraseña usando set
        $_SESSION['usuario'] = $resultado;
        session_unset('contraseña');//Revisar esto, no estoy segura de que sea así
        header("Location: MostrarParques.php");
        exit();
    }

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="css/inicio.css">
</head>
<body>

    <div class="contenedor">
        <div class="registro">
            <h3>Inicio de sesión</h3>
            <?php //Se muestra el mensaje si la contraseña o el correo no concuerdan
            if (!empty($errores)){
                echo "<div class='mensaje-error'>";
                echo "<p>$errores</p></div>";
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