<?php 
require_once "ParqueAtracciones.class.php";
require_once "ParquesDAO.class.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    $lista = ParquesDAO::getParqueAtracciones();

    foreach ($lista as $p) {
        echo $p->getNombre() . "<br>";
    }

    ?>

</body>

</html>