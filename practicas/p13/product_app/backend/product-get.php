<?php
// Paso 1: Usar el namespace correcto
namespace MyApi;

// Paso 2: Incluir el archivo que contiene la clase Products
include_once __DIR__ . '/myapi/Products.php';

// Paso 3: Crear una instancia de la clase Products
$products = new Products();

// Paso 4: Invocar el método que realiza la operación correspondiente (en este caso, obtener un producto por ID)
$productData = $products->getProductById($_GET['id']); // Método para obtener el producto por ID

// Paso 5: Usar el método getData() para devolver la respuesta en formato JSON
echo $productData ? json_encode($productData) : json_encode(['status' => 'error', 'message' => 'Producto no encontrado']);
?>
