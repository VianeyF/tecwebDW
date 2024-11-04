<?php
include 'database.php';

if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];
    $stmt = $conexion->prepare("SELECT COUNT(*) AS total FROM productos WHERE nombre = ?");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    echo json_encode(['existe' => $result['total'] > 0]);
}
?>
