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
        die("El nombre del producto es obligatorio y debe maximo 100 caracteres");
    }

    // Validar la marca 
    $marcasPermitidas = ['Lego', 'Fisher Price', 'Nenuco', 'Hasbro', 'Mattel', 'Barbie'];
    if (empty($marca) || !in_array($marca, $marcasPermitidas)) {
        die("Selecciona una marca");
    }


    if (empty($modelo) || strlen($modelo) > 25) {
        die("El modelo es obligatorio y debe tener maximo 25 caracteres");
    }

    if (!is_numeric($precio) || $precio < 99.99) {
        die("El precio es obligatorio y debe ser mayor a $ 99.99 MXN");
    }

    if (strlen($detalles) > 250) {
        die("Los detalles son opcionales, pero deben tener maximo 250 caracteres");
    }

    if (!is_numeric($unidades) || $unidades < 1) {
        die("Cada producto debe tener al menos una unidad");
    }

    // Validación del archivo de imagen
    if (!empty($imagen)) {
        $tipoArchivo = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
        $rutaArchivo = "uploads/" . basename($imagen);

        // Verificar tipo de archivo
        if ($tipoArchivo != "jpg" && $tipoArchivo != "png" && $tipoArchivo != "jpeg") {
            die("Solo se permiten archivos JPG, JPEG y PNG.");
        }

        // Subir archivo
        if (!move_uploaded_file($_FILES['imagen_producto']['tmp_name'], $rutaArchivo)) {
            die("Hubo un error al subir la imagen.");
        }
    } else {
        $rutaArchivo = "ruta/imagen_defecto.png"; 
    }

    @$link = new mysqli('localhost', 'root', 'vianey24', 'marketzone');

    if ($link->connect_errno) {
        die('Falló la conexión: ' . $link->connect_error);
    }

    // insertar los datos
    $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, ruta_imagen)
            VALUES ('$nombre', '$marca', '$modelo', '$precio', '$detalles', '$unidades', '$rutaArchivo')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Producto registrado con exito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cerrar la conexion
        $conn->close();
}
?>
