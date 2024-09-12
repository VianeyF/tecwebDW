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

    <!-- Ejercicio 1: Comprobar si un numero es multiplo de 5 y 7 
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
    </form>-->

    <!-- Ejercicio 2: Generar secuencia impar-par-impar 
<h2>Ejercicio 2: Generar secuencia impar-par-impar</h2>
<?php
if (isset($_POST['generar_numeros'])) {
    list($numeros, $iteraciones, $totalNumerosGenerados) = generarSecuenciaImparParImpar();
    echo "<p>Números generados: " . implode(", ", $numeros) . "</p>";
    echo "<p>Iteraciones: $iteraciones</p>";
    echo "<p>Total de números aleatorios generados: $totalNumerosGenerados</p>";  // Muestra el total de numeros generados
}
?>
<form method="POST" action="">
    <button type="submit" name="generar_numeros">Generar Secuencia</button>
</form>-->

<!-- Ejercicio 3: Encontrar número múltiplo de un numero dado
<h2>Ejercicio 3: Encontrar un numero multiplo de un numero dado</h2>
    <?php
    $multiplo = isset($_GET['multiplo']) ? $_GET['multiplo'] : null;
    if ($multiplo !== null) {
        $numeroEncontrado = encontrarMultiploWhile($multiplo);
        echo "<p>Primer numero multiplo de $multiplo encontrado: $numeroEncontrado</p>";
    }
    ?>
    <form method="GET" action="">
        <label for="multiplo">Ingrese el numero:</label>
        <input type="text" id="multiplo" name="multiplo">
        <button type="submit">Buscar</button>
    </form>-->

<!-- Ejercicio 4: Crear arreglo ASCII 
     <h2>Ejercicio 4: Crear arreglo de letras ASCII</h2>
    <?php
    if (isset($_POST['mostrar_arreglo'])) {
        $arreglo = crearArregloASCII();
        echo "<table border='1'>";
        foreach ($arreglo as $key => $value) {
            echo "<tr><td>$key</td><td>$value</td></tr>";
        }
        echo "</table>";
    }
    ?>
    <form method="POST" action="">
        <button type="submit" name="mostrar_arreglo">Mostrar Arreglo</button>
    </form>-->

    <!-- Ejercicio 5: Verificar edad y sexo -->
    <h2>Ejercicio 5: Verificar Edad y Sexo</h2>
    <?php
    if (isset($_POST['edad']) && isset($_POST['sexo'])) {
        $edad = $_POST['edad'];
        $sexo = $_POST['sexo'];
        $mensaje = verificarEdadYSexo($edad, $sexo);
        echo "<p>$mensaje</p>";
    }
    ?>
    <form method="POST" action="">
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required>

        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" required>
            <option value="femenino">Femenino</option>
            <option value="masculino">Masculino</option>
        </select>

        <button type="submit">Enviar</button>
    </form>


    </body>
</html>