<?php
require_once "ConsultasDAO.class.php";
session_start();
$errores = '';
$mensaje_exito = '';


if (isset($_POST['inicio'])){
    $correo=trim($_POST['email']);
    $contrasena=trim($_POST['contrasena']);
    $resultado = ConsultasDAO::inicioSesion($correo, $contrasena);
    if (!($resultado instanceof("Usuario"))){
        $errores = "La contraseña y el correo son incorrectos";
    }else{
        //Guardar el usuario directamente sin la contraseña usando set
        $_SESSION['usuario'] = $resultado;
        //Arreglar la sesión
        unset($_SESSION['usuario']->contrasena);
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
    
    <header class="header-registro">
        <div class="enlace-registro-contenedor">
            <p>Si no tienes cuenta:</p>
            <form action="registro.php" method="post">
                <button type="submit" class="boton-registro-flotante">Registrarse</button>
            </form>
        </div>
    </header>
    
    <div class="contenedor">
        <div class="registro">
            <h3>Inicio de sesión</h3>
            <?php //Se muestra el mensaje si la contraseña o el correo no concuerdan
            if (!empty($errores)){
                echo "<div class='mensaje-error'>";
                echo "<p>$errores</p></div>";
            }
            ?>

            <form action="index.php" method="POST">
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
    
    </body>
</html>