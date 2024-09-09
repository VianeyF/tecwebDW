<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P5 Verificacion variables PHP</title>
</head>
<body>
    <h2>Verificacion de variables en PHP</h2>
    <p>Validez de las variables:</p>
    <ul>
        <li>$_myvar: <?php echo 'valida';?></li>
        <li>$_7var: <?php echo 'valida';?></li>
        <li>myvar: <?php echo 'invalida, necesita $ al inicio';?></li>
        <li>$myvar: <?php echo 'valida';?></li>
        <li>$var7: <?php echo 'valida';?></li>
        <li>$_element1: <?php echo 'valida';?></li>
        <li>$house*5: <?php echo 'invalida, contiene un caracter especial *';?></li>
    </ul> 

    <?php
    //liberar variables
    unset($_myvar, $_7var, $myvar, $myvar, $var7, $_element1, $house5);
    ?>

<h2>Asignación de Variables</h2>

<?php
// Asignaciones iniciales
$a = "ManejadorSQL";
$b = 'MySQL';
$c = &$a;

// Mostrar el contenido inicial
echo "<p>Valores iniciales:</p>";
echo "<ul>";
echo "<li>\$a: "; var_dump($a); echo "</li>";
echo "<li>\$b: "; var_dump($b); echo "</li>";
echo "<li>\$c: "; var_dump($c); echo "</li>";
echo "</ul>";

// Nuevas asignaciones
$a = "PHP server";
$b = &$a;

// Mostrar el contenido después de las nuevas asignaciones
echo "<p>Valores después de las nuevas asignaciones:</p>";
echo "<ul>";
echo "<li>\$a: "; var_dump($a); echo "</li>";
echo "<li>\$b: "; var_dump($b); echo "</li>";
echo "<li>\$c: "; var_dump($c); echo "</li>";
echo "</ul>";

// Liberar variables
unset($a, $b, $c);
?>


</body>
</html>