<?php
// Paso 1: Usar el namespace correcto
namespace MyApi;

// Paso 2: Incluir el archivo que contiene la clase Products
include_once __DIR__ . '/myapi/Products.php';

// Paso 3: Crear una instancia de la clase Products
$products = new Products('localhost', 'marketzone', 'root', 'vianey24');

// Paso 4: Invocar el método para obtener productos por búsqueda
$data = $products->searchProducts($_GET['search']); // Usamos el método searchProducts para manejar la lógica

// Paso 5: Usar json_encode() para devolver la respuesta en formato JSON
echo json_encode($data, JSON_PRETTY_PRINT);
?>
