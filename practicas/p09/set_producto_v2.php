<?php
// Captura los datos del formulario
$nombre = $_POST['nombre_producto'];
$marca  = $_POST['marca_producto'];
$modelo = $_POST['modelo_producto'];
$precio = $_POST['precio_producto'];
$detalles = $_POST['detalles_producto'];
$unidades = $_POST['unidades_producto'];
$imagen = $_FILES['imagen_producto']['name'];
$tmp_name = $_FILES['imagen_producto']['tmp_name'];
$upload_dir = 'img/'; 
move_uploaded_file($tmp_name, $upload_dir . $imagen);

@$link = new mysqli('localhost', 'root', 'vianey24', 'marketzone');
if ($link->connect_errno) {
    die('<h1>Falló la conexión a la base de datos: '.$link->connect_error.'</h1>');
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
    // $sql_insert = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) 
    //                VALUES ('{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$upload_dir}{$imagen}', 0)";

    // NUEVA QUERY (EXCLUYENDO 'id' y 'eliminado'):
    $sql_insert = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) 
                   VALUES ('{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$upload_dir}{$imagen}')";

    if ($link->query($sql_insert)) {
        //mostrar resumen del producto insertado
        echo "<h1>Producto insertado con éxito</h1>";
        echo "<p><strong>ID:</strong> ".$link->insert_id."</p>";
        echo "<p><strong>Nombre:</strong> {$nombre}</p>";
        echo "<p><strong>Marca:</strong> {$marca}</p>";
        echo "<p><strong>Modelo:</strong> {$modelo}</p>";
        echo "<p><strong>Precio:</strong> {$precio}</p>";
        echo "<p><strong>Detalles:</strong> {$detalles}</p>";
        echo "<p><strong>Unidades disponibles:</strong> {$unidades}</p>";
        echo "<p><strong>Imagen:</strong> <img src='{$upload_dir}{$imagen}' alt='Imagen del producto' style='width:200px;'></p>";
    } else {
        // Error al insertar
        echo "<h1>Error: No se pudo insertar el producto</h1>";
        echo "<p>Error: ".$link->error."</p>";
    }
}

$link->close();
?>
