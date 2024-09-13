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

// Función para obtener el registro de vehículos
function obtenerParqueVehicular() {
    return [
        'ABC1234' => [
            'Auto' => ['marca' => 'Toyota', 'modelo' => 2020, 'tipo' => 'sedan'],
            'Propietario' => ['nombre' => 'Carlos Pérez', 'ciudad' => 'Ciudad de México', 'direccion' => 'Calle Falsa 123']
        ],
        'DEF5678' => [
            'Auto' => ['marca' => 'Honda', 'modelo' => 2019, 'tipo' => 'hatchback'],
            'Propietario' => ['nombre' => 'Ana Gómez', 'ciudad' => 'Monterrey', 'direccion' => 'Avenida Siempre Viva 742']
        ],
        'GHI9101' => [
            'Auto' => ['marca' => 'Mazda', 'modelo' => 2021, 'tipo' => 'camioneta'],
            'Propietario' => ['nombre' => 'Luis Sánchez', 'ciudad' => 'Guadalajara', 'direccion' => 'Calle Principal 456']
        ],
        'JKL2345' => [
            'Auto' => ['marca' => 'Ford', 'modelo' => 2018, 'tipo' => 'sedan'],
            'Propietario' => ['nombre' => 'María López', 'ciudad' => 'Tijuana', 'direccion' => 'Boulevard de las Estrellas 89']
        ],
        'MNO6789' => [
            'Auto' => ['marca' => 'Chevrolet', 'modelo' => 2017, 'tipo' => 'hatchback'],
            'Propietario' => ['nombre' => 'Juan Hernández', 'ciudad' => 'Puebla', 'direccion' => 'Calle Reforma 234']
        ],
        'PQR3456' => [
            'Auto' => ['marca' => 'Nissan', 'modelo' => 2022, 'tipo' => 'camioneta'],
            'Propietario' => ['nombre' => 'Laura Ramírez', 'ciudad' => 'Veracruz', 'direccion' => 'Calle Independencia 12']
        ],
        'STU7890' => [
            'Auto' => ['marca' => 'BMW', 'modelo' => 2021, 'tipo' => 'sedan'],
            'Propietario' => ['nombre' => 'Roberto Gutiérrez', 'ciudad' => 'Cancún', 'direccion' => 'Carretera Federal 500']
        ],
        'VWX1234' => [
            'Auto' => ['marca' => 'Mercedes', 'modelo' => 2020, 'tipo' => 'camioneta'],
            'Propietario' => ['nombre' => 'Sofía Martínez', 'ciudad' => 'Querétaro', 'direccion' => 'Calle del Sol 567']
        ],
        'YZA5678' => [
            'Auto' => ['marca' => 'Audi', 'modelo' => 2019, 'tipo' => 'hatchback'],
            'Propietario' => ['nombre' => 'David Torres', 'ciudad' => 'San Luis Potosí', 'direccion' => 'Avenida Libertad 76']
        ],
        'BCD9101' => [
            'Auto' => ['marca' => 'Volkswagen', 'modelo' => 2021, 'tipo' => 'sedan'],
            'Propietario' => ['nombre' => 'Julia Vázquez', 'ciudad' => 'Toluca', 'direccion' => 'Calle de la Paz 78']
        ],
        'EFG2345' => [
            'Auto' => ['marca' => 'Peugeot', 'modelo' => 2022, 'tipo' => 'camioneta'],
            'Propietario' => ['nombre' => 'Alejandro García', 'ciudad' => 'León', 'direccion' => 'Avenida Insurgentes 345']
        ],
        'HIJ6789' => [
            'Auto' => ['marca' => 'Kia', 'modelo' => 2018, 'tipo' => 'hatchback'],
            'Propietario' => ['nombre' => 'Fernanda Ruiz', 'ciudad' => 'Aguascalientes', 'direccion' => 'Calle 5 de Mayo 101']
        ],
        'KLM3456' => [
            'Auto' => ['marca' => 'Tesla', 'modelo' => 2021, 'tipo' => 'sedan'],
            'Propietario' => ['nombre' => 'Pedro Delgado', 'ciudad' => 'Chihuahua', 'direccion' => 'Calle Río Grande 90']
        ],
        'NOP7890' => [
            'Auto' => ['marca' => 'Hyundai', 'modelo' => 2022, 'tipo' => 'camioneta'],
            'Propietario' => ['nombre' => 'Luisa Moreno', 'ciudad' => 'Saltillo', 'direccion' => 'Calle Reforma 123']
        ]
    ];
}

// Función para obtener información de un vehículo dado su matrícula
function obtenerInformacionVehiculo($matricula) {
    $vehiculos = obtenerParqueVehicular();
    if (array_key_exists($matricula, $vehiculos)) {
        return $vehiculos[$matricula];
    } else {
        return null;
    }
}
?>


?>