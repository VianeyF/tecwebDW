<?php
include 'database.php'; // Conexión a la base de datos

$id = $_GET['id'];
$sql = "SELECT * FROM productos WHERE id = $id";
$result = $conexion->query($sql);
if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(['status' => 'error', 'message' => 'Producto no encontrado']);
}
?>
