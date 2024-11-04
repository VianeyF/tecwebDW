<?php
    // Incluye la conexión a la base de datos
    include_once __DIR__.'/database.php';

    // Asegura que la respuesta sea JSON
    header('Content-Type: application/json');

    // Obtiene la información del producto enviada por el cliente
    $producto = file_get_contents('php://input');

    // Inicializa el array de respuesta
    $data = array(
        'status'  => 'error',
        'message' => 'Error en el procesamiento del producto'
    );

    if (!empty($producto)) {
        // Transforma el string del JSON a objeto
        $jsonOBJ = json_decode($producto);

        // Validación de datos necesarios
        if (isset($jsonOBJ->nombre, $jsonOBJ->marca, $jsonOBJ->modelo, $jsonOBJ->precio, $jsonOBJ->detalles, $jsonOBJ->unidades)) {
            $nombre = $conexion->real_escape_string($jsonOBJ->nombre);
            $marca = $conexion->real_escape_string($jsonOBJ->marca);
            $modelo = $conexion->real_escape_string($jsonOBJ->modelo);
            $precio = floatval($jsonOBJ->precio);
            $detalles = $conexion->real_escape_string($jsonOBJ->detalles);
            $unidades = intval($jsonOBJ->unidades);

            // Verificar si el producto ya existe
            $sql = "SELECT * FROM productos WHERE nombre = '$nombre' AND eliminado = 0";
            $result = $conexion->query($sql);

            if ($result->num_rows == 0) {
                // Si no existe, se inserta el producto
                $conexion->set_charset("utf8");
                $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, eliminado) VALUES ('$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, 0)";

                if ($conexion->query($sql)) {
                    $data['status'] = "success";
                    $data['message'] = "Producto agregado";
                } else {
                    $data['message'] = "ERROR: No se pudo ejecutar la consulta. " . $conexion->error;
                }
            } else {
                $data['message'] = "Ya existe un producto con ese nombre";
            }

            $result->free();
        } else {
            $data['message'] = "Datos incompletos o inválidos.";
        }
        
        // Cierra la conexión
        $conexion->close();
    }

    // Envía la respuesta como JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>
