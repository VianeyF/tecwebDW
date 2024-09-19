<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>ProductosTope</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .imagen-producto {
            width: 300px; /* Tamaño ajustado de las imagenes */
            height: auto;
        }
    </style>
</head>
<body>
    <h3>Lista de productos con un numero de unidades menor o igual a <?php echo htmlspecialchars($_GET['tope']); ?></h3>

    <?php
    if (isset($_GET['tope']) && is_numeric($_GET['tope'])) {
        $tope = intval($_GET['tope']);

        // Conexión a la base de datos
        @$link = new mysqli('localhost', 'root', 'vianey24', 'marketzone');

        if ($link->connect_errno) {
            die('Falló la conexión: ' . $link->connect_error);
        }

        // Consulta para seleccionar productos con unidades <= al tope
        $query = "SELECT * FROM productos WHERE unidades <= ?";
        if ($stmt = $link->prepare($query)) {
            $stmt->bind_param("i", $tope);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<table class="table">';
                echo '<thead class="thead-dark"><tr>';
                echo '<th>#</th><th>Nombre</th><th>Marca</th><th>Modelo</th><th>Precio</th><th>Unidades</th><th>Imagen</th>';
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
                    echo '</tr>';
                }

                echo '</tbody></table>';
            } else {
                echo '<p>No se encontraron productos con menos o igual unidades que ' . htmlspecialchars($tope) . '.</p>';
            }

            $stmt->close();
        }

        $link->close();
    } else {
        echo '<p>Por favor, proporciona un valor valido para el tope.</p>';
    }
    ?>
</body>
</html>
