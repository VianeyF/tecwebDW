<?php 
// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Función para limpiar y validar entradas
    function limpiarEntrada($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Obtener y limpiar los datos
    $nombre = limpiarEntrada($_POST['nombre_producto']);
    $marca = limpiarEntrada($_POST['marca_producto']);
    $modelo = limpiarEntrada($_POST['modelo_producto']);
    $precio = limpiarEntrada($_POST['precio_producto']);
    $detalles = limpiarEntrada($_POST['detalles_producto']);
    $unidades = limpiarEntrada($_POST['unidades_producto']);
    $imagen = $_FILES['imagen_producto']['name'];

    // Validaciones del lado del servidor
    if (empty($nombre) || strlen($nombre) > 100) {
        die("El nombre del producto puede tener un máximo de 100 caracteres");
    }

    // Validar la marca 
    $marcasPermitidas = ['Lego', 'Fisher Price', 'Nenuco', 'Hasbro', 'Mattel', 'Barbie'];
    if (empty($marca) || !in_array($marca, $marcasPermitidas)) {
        die("Selecciona una marca");
    }

    if (empty($modelo) || strlen($modelo) > 25) {
        die("El modelo puede tener un máximo de 25 caracteres");
    }

    if (!is_numeric($precio) || $precio < 99.99) {
        die("El precio debe ser mayor a $ 99.99 MXN");
    }

    if (strlen($detalles) > 250) {
        die("Los detalles pueden tener un máximo de 250 caracteres");
    }

    if (!is_numeric($unidades) || $unidades < 1) {
        die("Cada producto debe tener al menos una unidad");
    }

    // Validación del archivo de imagen
    if (!empty($imagen)) {
        $tipoArchivo = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
        $rutaArchivo = "img/" . basename($imagen);

        // Verificar tipo de archivo
        if ($tipoArchivo != "jpg" && $tipoArchivo != "png" && $tipoArchivo != "jpeg") {
            die("Solo se permiten archivos JPG, JPEG y PNG.");
        }

        // Subir archivo
        if (!move_uploaded_file($_FILES['imagen_producto']['tmp_name'], $rutaArchivo)) {
            die("Hubo un error al subir la imagen.");
        }
    } else {
        $rutaArchivo = "img/imagen_defecto.png"; 
    }

    // Conectar con la base de datos
    @$link = new mysqli('localhost', 'root', 'vianey24', 'marketzone');

    if ($link->connect_errno) {
        die('Falló la conexión: ' . $link->connect_error);
    }

    // Validar que el producto no exista (nombre, marca y modelo deben ser únicos)
    $sql_check = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND marca = '{$marca}' AND modelo = '{$modelo}'";
    $result = $link->query($sql_check);

    if ($result->num_rows > 0) {
        // Producto ya existe, mostrar error
        echo "<h1>Error: El producto ya existe en la base de datos</h1>";
        echo "<p>Producto: {$nombre}, Marca: {$marca}, Modelo: {$modelo}</p>";
    } else {
        // Insertar el nuevo producto en la base de datos
        $sql_insert = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) 
                       VALUES ('$nombre', '$marca', '$modelo', '$precio', '$detalles', '$unidades', '$rutaArchivo')";

        if ($link->query($sql_insert)) {
            // Mostrar resumen del producto insertado
            echo "<h1>Producto insertado con éxito</h1>";
            echo "<p><strong>ID:</strong> ".$link->insert_id."</p>";
            echo "<p><strong>Nombre:</strong> {$nombre}</p>";
            echo "<p><strong>Marca:</strong> {$marca}</p>";
            echo "<p><strong>Modelo:</strong> {$modelo}</p>";
            echo "<p><strong>Precio:</strong> {$precio}</p>";
            echo "<p><strong>Detalles:</strong> {$detalles}</p>";
            echo "<p><strong>Unidades disponibles:</strong> {$unidades}</p>";
            echo "<p><strong>Imagen:</strong> <img src='{$rutaArchivo}' alt='Imagen del producto' style='width:200px;'></p>";
        } else {
            // Error al insertar
            echo "<h1>Error: No se pudo insertar el producto</h1>";
            echo "<p>Error: ".$link->error."</p>";
        }
    }

    // Cerrar la conexión
    $link->close();
}
?>
