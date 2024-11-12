<?php
// Usar autoloading de Composer (si estás utilizando Composer)
require_once __DIR__ . '/vendor/autoload.php'; 

use MyApi\Controllers\Create; 

// Crear una instancia de la clase Create (la cual maneja la inserción de productos)
$create = new Create();

// Asegurarse de que la respuesta sea JSON
header('Content-Type: application/json');

// Obtener los datos enviados por el cliente (producto a agregar)
$producto = file_get_contents('php://input');

if (!empty($producto)) {
    // Transformar el string del JSON a objeto
    $jsonOBJ = json_decode($producto);

    // Verificar si la decodificación fue exitosa
    if ($jsonOBJ === null) {
        echo json_encode([
            'status' => 'error',
            'message' => 'JSON mal formado.'
        ], JSON_PRETTY_PRINT);
        exit;
    }

    // Validación de datos necesarios
    if (isset($jsonOBJ->nombre, $jsonOBJ->marca, $jsonOBJ->modelo, $jsonOBJ->precio, $jsonOBJ->detalles, $jsonOBJ->unidades)) {
        // Asignar valor a 'eliminado' por defecto (0)
        $jsonOBJ->eliminado = 0;  // O el valor que sea adecuado según tu lógica

        try {
            // Usamos el método add() de la clase Create para agregar el producto
            $create->add($jsonOBJ);

            // Devolver una respuesta exitosa en formato JSON
            echo json_encode([
                'status' => 'success',
                'message' => 'Producto agregado correctamente.'
            ], JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al agregar el producto: ' . $e->getMessage()
            ], JSON_PRETTY_PRINT);
        }
    } else {
        // Si no se reciben todos los datos necesarios
        echo json_encode([
            'status' => 'error',
            'message' => 'Datos incompletos o inválidos.'
        ], JSON_PRETTY_PRINT);
    }
} else {
    // Si no se recibe ningún dato
    echo json_encode([
        'status' => 'error',
        'message' => 'No se recibió ningún dato.'
    ], JSON_PRETTY_PRINT);
}
?>
