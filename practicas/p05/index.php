<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P5 Verificacion variables PHP</title>
</head>
<body>
    <hi>Verificacion de variables en PHP</h1>
    <p>Validez de las variables</p>
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
</body>
</html>