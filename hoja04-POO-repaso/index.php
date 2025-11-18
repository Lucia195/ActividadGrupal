<?php
require_once "Pelicula.class.php";
require_once "Actor.class.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de películas</title>
</head>
<body>
    <h1>Buscador de películas</h1>
    <?php
    $peliculas = [
        new Pelicula("Amienemigos", "img/Amienemigos.jpeg", [
            new Actor("Persona1"),
            new Actor("Persona2")
        ] ),
        new Pelicula("Zótropolis", "img/Zótropolis.jpeg", [
            new Actor("Persona1"),
            new Actor("Persona3")
        ]),
        new Pelicula("Culpa mía", "img/Culpa mia.jpeg", [
            new Actor("Persona4"),
            new Actor("Persona5")
        ] ),
        new Pelicula("Culpa tuya", "img/Culpa tuya.jpeg", [
            new Actor("Persona4"),
            new Actor("Persona5")
        ] ),
        new Pelicula("Culpa nuestra", "img/Culpa nuestra.jpeg", [
            new Actor("Persona4"),
            new Actor("Persona5")
        ] ),
        new Pelicula("Aladin", "img/Aladin.jpeg", [
            new Actor("Persona6"),
            new Actor("Persona7")
        ] ),
        new Pelicula("Camp Rock 2", "img/Camp Rock 2.jpeg", [
            new Actor("Persona3"),
            new Actor("Persona6")
        ] ),
        new Pelicula("Rescate en Nueva York", "img/Rescate en Nueva York.jpeg", [
            new Actor("Persona8"),
            new Actor("Persona9")
        ] ),
    ];
    ?>
    
    <form action="index.php" method="post">
        <label for="buscador">Buscador</label>
        <input type="text" id="buscador" name="buscador" value="<?php echo isset($_POST['buscador']) ? htmlspecialchars($_POST['buscador']) : ''; ?>">
        <button type="submit">Buscar</button>
    </form>
    
    <?php
    $encontrados = 0;

    if (isset($_POST['buscador']) && !empty($_POST['buscador'])) {
        $busqueda = strtolower(trim($_POST['buscador']));
        $resultados = [];
        foreach ($peliculas as $pelicula) {
            if (str_contains(strtolower($pelicula->getTitulo()), $busqueda)) { 
                $resultados[] = $pelicula;
                $encontrados++;
            }
        }
        echo "<div><strong>$encontrados película" . ($encontrados != 1 ? 's' : '') . " encontrada" . ($encontrados != 1 ? 's' : '') . " para la búsqueda \"$busqueda\"</strong></div>";

        if ($encontrados > 0) {
            echo "<table>";
            echo "<tr><th>Póster</th><th>Título</th><th>Actores</th></tr>";
            
            foreach ($resultados as $pelicula) {
                echo "<tr>";
                echo "<td><img src='" . htmlspecialchars($pelicula->getImagen()) . "' alt='" . htmlspecialchars($pelicula->getTitulo()) . "' style='width: 100px; height: auto;'></td>";
                echo "<td>" . htmlspecialchars($pelicula->getTitulo()) . "</td>";
                echo "<td>";
                foreach ($pelicula->getActores() as $actor) {
                    echo htmlspecialchars($actor->getNombre()) . "<br>";
                }
                echo "</td>";
                
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    ?>
</body>
</html>