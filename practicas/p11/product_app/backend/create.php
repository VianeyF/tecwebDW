<?php
    include_once __DIR__.'/database.php';

    // Obtener los datos enviados por el cliente
    $producto = file_get_contents('php://input');
    if (!empty($producto)) {
        $jsonOBJ = json_decode($producto);

        // Validar si el producto ya existe
        $nombre = $jsonOBJ->nombre;
        $sql_check = "SELECT * FROM productos WHERE nombre = ? AND eliminado = 0";
        $stmt_check = $conexion->prepare($sql_check);
        $stmt_check->bind_param("s", $nombre);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            echo "Error: El producto ya existe.";
        } else {
            // Insertar el nuevo producto
            $sql_insert = "INSERT INTO productos (nombre, marca, modelo, precio, unidades, detalles, imagen) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert = $conexion->prepare($sql_insert);
            $stmt_insert->bind_param("sssdiss", $jsonOBJ->nombre, $jsonOBJ->marca, $jsonOBJ->modelo, $jsonOBJ->precio, $jsonOBJ->unidades, $jsonOBJ->detalles, $jsonOBJ->imagen);

            if ($stmt_insert->execute()) {
                echo "Éxito: Producto agregado correctamente.";
            } else {
                echo "Error: No se pudo agregar el producto.";
            }
        }
    } else {
        echo "Error: No se recibieron datos.";
    }
?>
