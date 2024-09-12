<?php
// Funcion para comprobar si un número es múltiplo de 5 y 7
function esMultiploDeCincoYSiete($numero) {
    return ($numero % 5 == 0 && $numero % 7 == 0);
}

// Funcion para generar secuencia impar-par-impar
function generarSecuenciaImparParImpar() {
    $numeros = [];
    $iteraciones = 0;
    $totalNumerosGenerados = 0;  // Contador total de numeros aleatorios generados

    do {
        $numeros = [];
        for ($i = 0; $i < 3; $i++) {
            $numero = rand(1, 1000);
            $numeros[] = $numero;
            $totalNumerosGenerados++;  // Aumenta el contador cada vez que se genera un numero
        }
        $iteraciones++;
    } while (!($numeros[0] % 2 != 0 && $numeros[1] % 2 == 0 && $numeros[2] % 2 != 0));

    return [$numeros, $iteraciones, $totalNumerosGenerados];
}

// Funcion para encontrar un número aleatorio múltiplo de un número dado (while)
function encontrarMultiploWhile($multiplo) {
    do {
        $numero = rand(1, 1000);
    } while ($numero % $multiplo != 0);

    return $numero;
}

// Funcion para crear un arreglo con los caracteres ASCII de 'a' a 'z'
function crearArregloASCII() {
    $arreglo = [];
    for ($i = 97; $i <= 122; $i++) {
        $arreglo[$i] = chr($i);
    }
    return $arreglo;
}

// Funcion para verificar si la edad y el sexo cumplen los requisitos
function verificarEdadYSexo($edad, $sexo) {
    if ($sexo === 'femenino' && $edad >= 18 && $edad <= 35) {
        return "Bienvenida, usted esta en el rango de edad permitido.";
    } else {
        return "Lo siento, usted no cumple con los requisitos.";
    }
}

?>