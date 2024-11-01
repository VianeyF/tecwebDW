<?php
include 'database.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];  // ID del producto a actualizar
$nombre = $data['nombre'];
$precio = $data['precio'];
$unidades = $data['unidades'];
$modelo = $data['modelo'];
$marca = $data['marca'];
$detalles = $data['detalles'];

if ($unidades < 1) {
    echo json_encode(['status' => 'error, edicion fallida', 'message' => 'El número de unidades no puede ser menor a 1.']);
    exit();
}

$sql = "UPDATE productos SET nombre='$nombre', precio=$precio, unidades=$unidades, modelo='$modelo', marca='$marca', detalles='$detalles' WHERE id = $id";

if ($conexion->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Producto actualizado correctamente']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el producto']);
}
?>