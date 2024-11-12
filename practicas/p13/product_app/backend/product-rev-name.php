<?php
namespace MyApi;

include_once __DIR__ . 'myapi/Products.php';

$product = new Products();

if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];
    
    // Usa el método correspondiente en Products para verificar si existe
    $product->checkIfExists($nombre);
    
    // Devuelve el resultado en formato JSON usando getData()
    echo json_encode($product->getData());
}
?>
