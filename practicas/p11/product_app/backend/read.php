<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();

    // BÚSQUEDA POR ID
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        // SE REALIZA LA QUERY DE BÚSQUEDA POR ID
        if ($result = $conexion->query("SELECT * FROM productos WHERE id = '{$id}'")) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            // SI SE ENCUENTRA UN PRODUCTO CON ESE ID
            if (!is_null($row)) {
                // CODIFICAR LOS DATOS Y MAPEARLOS AL ARRAY
                foreach ($row as $key => $value) {
                    $data[$key] = utf8_encode($value);
                }
            }
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($conexion));
        }

    // BÚSQUEDA POR TÉRMINO DE BÚSQUEDA (NOMBRE, MARCA O DETALLES)
    } elseif (isset($_POST['search_term']) && !empty($_POST['search_term'])) {
        $search_term = $conexion->real_escape_string($_POST['search_term']);

        // SE REALIZA LA CONSULTA DE BÚSQUEDA UTILIZANDO LIKE
        $query = "SELECT * FROM productos 
                  WHERE nombre LIKE '%{$search_term}%' 
                  OR marca LIKE '%{$search_term}%' 
                  OR detalles LIKE '%{$search_term}%'";
        
        // SE EJECUTA LA QUERY Y SE VALIDA SI HUBO RESULTADOS
        if ($result = $conexion->query($query)) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $producto = array();
                foreach ($row as $key => $value) {
                    $producto[$key] = utf8_encode($value);
                }
                $data[] = $producto;  // SE AGREGA CADA PRODUCTO AL ARRAY
            }
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($conexion));
        }
    }

    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);

    // CERRAR CONEXIÓN
    $conexion->close();
?>
