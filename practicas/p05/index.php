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


//liberar variables
unset($a, $b, $c);
?>

<?php
// Parte 3: Evolución de las variables

echo '<h2>Evolución de las Variables</h2>';
echo '<ul>';

// Asignaciones y evolución de las variables

$a = 'PHP5';
echo '<li>Después de asignar "PHP5" a $a, el valor de $a es: '; 
var_dump($a); 
echo '</li>';

$z[] = &$a;
echo '<li>Después de asignar la referencia de $a a $z[0], el valor de $z es: '; 
var_dump($z); 
echo '</li>';

$b = 5; // Cambiar a un valor numérico para evitar problemas
echo '<li>Después de asignar 5 a $b, el valor de $b es: '; 
var_dump($b); 
echo '</li>';

$c = $b * 10;
echo '<li>Después de multiplicar $b por 10, el valor de $c es: '; 
var_dump($c); 
echo '</li>';

$a .= $b;
echo '<li>Después de concatenar $b a $a, el valor de $a es: '; 
var_dump($a); 
echo '</li>';

$b *= $c;
echo '<li>Después de multiplicar $b por $c, el valor de $b es: '; 
var_dump($b); 
echo '</li>';

$z[0] = 'MySQL';
echo '<li>Después de asignar "MySQL" a $z[0], el valor de $z es: '; 
var_dump($z); 
echo '</li>';

echo '</ul>';

// Parte 4: Uso de $GLOBALS
echo '<h2>Uso de $GLOBALS</h2>';
echo '<ul>';

echo '<li>$GLOBALS[\'a\']: '; 
var_dump($GLOBALS['a']); 
echo '</li>';

echo '<li>$GLOBALS[\'b\']: '; 
var_dump($GLOBALS['b']); 
echo '</li>';

echo '<li>$GLOBALS[\'c\']: '; 
var_dump($GLOBALS['c']); 
echo '</li>';

echo '<li>$GLOBALS[\'z\']: '; 
var_dump($GLOBALS['z']); 
echo '</li>';

echo '</ul>';

// Liberar variables
unset($a, $b, $c, $z);
?>
</body>
</html>