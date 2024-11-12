<?php
// Paso 1: Usar el namespace correcto
namespace MyApi;

// Paso 2: Incluir el archivo que contiene la clase Products
include_once __DIR__ . '/myapi/Products.php';

header('Content-Type: application/json');

// Paso 3: Crear una instancia de la clase Products
$products = new Products('marketzone', 'localhost', 'root', 'vianey24');


// Paso 4: Invocar el método para actualizar un producto
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$nombre = $data['nombre'];
$precio = $data['precio'];
$unidades = $data['unidades'];
$modelo = $data['modelo'];
$marca = $data['marca'];
$detalles = $data['detalles'];

$product = (object) [
    'id' => $data['id'] ?? null,
    'nombre' => $data['nombre'] ?? null,
    'precio' => $data['precio'] ?? null,
    'detalles' => $data['detalles'] ?? null,
    'marca' => $data['marca'] ?? null,
    'modelo' => $data['modelo'] ?? null,
    'unidades' => $data['unidades'] ?? null
];

// Llamar al método de edición, pasando el objeto del producto que incluye el id
$products->edit($product);

// Paso 5: Devolver la respuesta en formato JSON
echo json_encode($products->getData(), JSON_PRETTY_PRINT);
?>
