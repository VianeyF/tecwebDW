<?php
include 'src/funciones.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Practica de PHP</title>
</head>
<body>
    <h1>Practica 07 PHP - Ejercicios</h1>

    <!-- Ejercicio 1: Comprobar si un número es múltiplo de 5 y 7 -->
    <h2>Ejercicio 1: Comprobar si un numero es multiplo de 5 y 7</h2>
    <?php
    $numero = isset($_GET['numero']) ? $_GET['numero'] : null;
    if ($numero !== null) {
        if (esMultiploDeCincoYSiete($numero)) {
            echo "<p>El numero $numero es multiplo de 5 y 7.</p>";
        } else {
            echo "<p>El numero $numero no es multiplo de 5 y 7.</p>";
        }
    }
    ?>
    <form method="GET" action="">
        <label for="numero">Ingrese un número:</label>
        <input type="text" id="numero" name="numero">
        <button type="submit">Comprobar</button>
    </form>

     <!-- Ejercicio 2: Generar secuencia impar-par-impar -->
     <h2>Ejercicio 2: Generar secuencia impar-par-impar</h2>
    <?php
    if (isset($_POST['generar_numeros'])) {
        list($numeros, $iteraciones) = generarSecuenciaImparParImpar();
        echo "<p>Números generados: " . implode(", ", $numeros) . "</p>";
        echo "<p>Iteraciones: $iteraciones</p>";
    }
    ?>
    <form method="POST" action="">
        <button type="submit" name="generar_numeros">Generar Secuencia Impar-Par-Impar</button>
    </form>

    </body>
</html>