<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Productos vigentes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .imagen-producto {
            width: 100px; /* Tamaño ajustado de las imágenes */
            height: auto;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <h3>Lista de productos vigentes</h3>

    <?php
    @$link = new mysqli('localhost', 'root', 'vianey24', 'marketzone');

    if ($link->connect_errno) {
        die('Falló la conexión: ' . $link->connect_error);
    }

    // Consulta productos que no están eliminados (eliminado = 0)
    $query = "SELECT * FROM productos WHERE eliminado = 0";
    if ($stmt = $link->prepare($query)) {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<table class="table">';
            echo '<thead class="thead-dark"><tr>';
            echo '<th>#</th><th>Nombre</th><th>Marca</th><th>Modelo</th><th>Precio</th><th>Unidades</th><th>Imagen</th><th>Modificar</th>'; // Agregado encabezado "Modificar"
            echo '</tr></thead><tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['nombre']) . '</td>';
                echo '<td>' . htmlspecialchars($row['marca']) . '</td>';
                echo '<td>' . htmlspecialchars($row['modelo']) . '</td>';
                echo '<td>' . htmlspecialchars($row['precio']) . '</td>';
                echo '<td>' . htmlspecialchars($row['unidades']) . '</td>';
                echo '<td><img src="' . htmlspecialchars($row['imagen']) . '" class="imagen-producto" alt="Imagen del producto"></td>';
                // Columna Modificar con el botón dentro de la celda
                echo '<td><a href="formulario_productos_v2.php?id=' . $row['id'] . '&nombre=' . urlencode($row['nombre']) . '&marca=' . urlencode($row['marca']) . '&precio=' . $row['precio'] . '&unidades=' . $row['unidades'] . '" class="btn btn-primary">Modificar</a></td>';
                echo '</tr>';
            }

            echo '</tbody></table>';
        } else {
            echo '<p>No hay productos en el inventario.</p>';
        }

        $stmt->close();
    }

    $link->close();
    ?>
</div>
</body>
</html>
