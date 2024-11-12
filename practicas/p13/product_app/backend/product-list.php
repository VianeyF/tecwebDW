<?php
// Paso 1: Incluir el autoload de Composer
require_once __DIR__ . '/myapi/vendor/autoload.php';

// Paso 2: Usar el namespace correcto para la clase Read
use Fvian\MyApi\Controllers\Read;

// Paso 3: Crear una instancia de la clase Read para manejar la lectura de productos
$read = new Read();

// Paso 4: Invocar el método que lista los productos
$products = $read->getAllProducts();

// Paso 5: Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($products, JSON_PRETTY_PRINT);
?>
