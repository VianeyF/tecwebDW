<?php
// Paso 1: Usar el namespace correcto
namespace MyApi;

// Paso 2: Incluir el archivo que contiene la clase Products
include_once __DIR__ . '/myapi/Products.php';

// Paso 3: Crear una instancia de la clase Products
$products = new Products();

// Paso 4: Invocar el método que lista los productos
$products->getAllProducts(); 

// Paso 5: Usar el método getData() para devolver la respuesta en formato JSON
echo $products->getData();
?>
