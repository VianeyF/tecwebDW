<?php
// Paso 1: Usar el namespace correcto
namespace MyApi;

// Paso 2: Incluir el archivo que contiene la clase Products
include_once __DIR__ . '/myapi/Products.php';

// Paso 3: Crear una instancia de la clase Products
$products = new Products('marketzone', 'localhost',  'root', 'vianey24');

// Paso 4: Invocar el método para elimin'localhost', ar el producto
$data = [
    'status' => 'error',
    'message' => 'La consulta falló'
];

// Verificamos si hemos recibido un ID para eliminar el producto
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Paso 4: Llamar al método para eliminar el producto
    $response = $products->deleteProduct($id);

    // Actualizamos los datos de la respuesta con el resultado de la operación
    $data = $response;
}

// Paso 5: Devolver la respuesta en formato JSON
echo json_encode($data, JSON_PRETTY_PRINT);
?>
