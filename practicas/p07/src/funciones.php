<?php
// Función para comprobar si un número es múltiplo de 5 y 7
function esMultiploDeCincoYSiete($numero) {
    return ($numero % 5 == 0 && $numero % 7 == 0);
}

// Función para generar secuencia impar-par-impar
function generarSecuenciaImparParImpar() {
    $numeros = [];
    $iteraciones = 0;

    do {
        $numeros = [];
        for ($i = 0; $i < 3; $i++) {
            $numero = rand(1, 1000);
            $numeros[] = $numero;
        }
        $iteraciones++;
    } while (!($numeros[0] % 2 != 0 && $numeros[1] % 2 == 0 && $numeros[2] % 2 != 0));

    return [$numeros, $iteraciones];
}

?>