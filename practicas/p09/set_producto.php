<?php
// Capturamos los datos del formulario
$nombre = $_POST['nombre_producto'];
$marca  = $_POST['marca_producto'];
$modelo = $_POST['modelo_producto'];
$precio = $_POST['precio_producto'];
$detalles = $_POST['detalles_producto'];
$unidades = $_POST['unidades_producto'];

// Capturamos la imagen y la movemos a la carpeta de destino
$imagen = $_FILES['imagen_producto']['name'];
$tmp_name = $_FILES['imagen_producto']['tmp_name'];
$upload_dir = 'img/';  // Carpeta donde se guardarán las imágenes
move_uploaded_file($tmp_name, $upload_dir . $imagen);

// Conexión a la base de datos
@$link = new mysqli('localhost', 'root', 'vianey24', 'marketzone');    

// Comprobar la conexión
if ($link->connect_errno) {
    die('Falló la conexión: '.$link->connect_error.'<br/>');
}

// Consulta para insertar el producto
$sql = "INSERT INTO productos VALUES (null, '{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$upload_dir}{$imagen}')";
if ($link->query($sql)) {
    echo 'Producto insertado con ID: '.$link->insert_id;
} else {
    echo 'El Producto no pudo ser insertado =(';
}

// Cerrar conexión
$link->close();
?>
