<?php
// Inicializar variable de mensaje de éxito
$mensajeExito = '';

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar a la base de datos
    @$link = new mysqli('localhost', 'root', 'vianey24', 'marketzone');

    if ($link->connect_errno) {
        die('Error de conexión: ' . $link->connect_error);
    }

    // Validar si los parámetros existen
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : null;
    $marca = isset($_POST['marca']) ? htmlspecialchars(trim($_POST['marca'])) : null;
    $modelo = isset($_POST['modelo']) ? htmlspecialchars(trim($_POST['modelo'])) : null;
    $precio = isset($_POST['precio']) ? floatval($_POST['precio']) : null;
    $unidades = isset($_POST['unidades']) ? intval($_POST['unidades']) : null;
    $detalles = isset($_POST['detalles']) ? htmlspecialchars(trim($_POST['detalles'])) : '';
    
    // Manejo de la imagen
    $imagen = '';
    if (isset($_FILES['imagen_producto']) && $_FILES['imagen_producto']['error'] == UPLOAD_ERR_OK) {
        // Verificar tipo de archivo
        $tipoArchivo = strtolower(pathinfo($_FILES['imagen_producto']['name'], PATHINFO_EXTENSION));
        $rutaArchivo = "img/" . basename($_FILES['imagen_producto']['name']);

        if ($tipoArchivo == "jpg" || $tipoArchivo == "jpeg" || $tipoArchivo == "png") {
            if (move_uploaded_file($_FILES['imagen_producto']['tmp_name'], $rutaArchivo)) {
                $imagen = $rutaArchivo; // Guardar la ruta de la imagen subida
            } else {
                echo "<h1>Error: No se pudo subir la imagen.</h1>";
            }
        } else {
            echo "<h1>Error: Solo se permiten archivos JPG, JPEG y PNG.</h1>";
        }
    } else {
        // Si no se ha subido una imagen, mantener la imagen anterior (si está disponible)
        $imagen = isset($_POST['imagen_anterior']) ? htmlspecialchars(trim($_POST['imagen_anterior'])) : 'img/imagen_defecto.png';
    }

    // Actualizar el producto en la base de datos
    $sql_update = "UPDATE productos SET nombre='$nombre', marca='$marca', modelo='$modelo', precio='$precio', unidades='$unidades', detalles='$detalles', imagen='$imagen' WHERE id='$id'";

    if ($link->query($sql_update) === TRUE) {
        $mensajeExito = "Producto actualizado con éxito. ID: $id, Nombre: $nombre, Marca: $marca, Modelo: $modelo, Precio: $precio, Unidades: $unidades.";
    } else {
        echo "<h1>Error: No se pudo actualizar el producto</h1>";
        echo "<p>Error: " . $link->error . "</p>";
    }

    // Cerrar la conexión
    $link->close();
}

// Obtener datos del producto si se pasa el ID
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    @$link = new mysqli('localhost', 'root', 'vianey24', 'marketzone');

    if ($link->connect_errno) {
        die('Error de conexión: ' . $link->connect_error);
    }

    $id = intval($_GET['id']);
    $result = $link->query("SELECT * FROM productos WHERE id = $id");
    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        $nombre = $producto['nombre'];
        $marca = $producto['marca'];
        $modelo = $producto['modelo'];
        $precio = $producto['precio'];
        $unidades = $producto['unidades'];
        $detalles = $producto['detalles'];
        $imagen = $producto['imagen'];
    } else {
        echo "<h1>Error: Producto no encontrado</h1>";
    }
    $link->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventario ToyStore</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-top: 20px;
        }
        form {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }
        input[type="submit"], input[type="reset"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }
        input[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #218838;
        }
        label {
            color: #333;
        }
        .form-control {
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        fieldset {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
        }
        legend {
            color: #333;
            font-weight: bold;
        }
        .imagen-producto {
            max-width: 200px; /* Ajusta el tamaño de la imagen */
            height: auto;
        }
    </style>

    <script>
        function validarFormulario() {
            var nombre = document.getElementById("nombre").value.trim();
            var marca = document.getElementById("marca").value.trim();
            var modelo = document.getElementById("modelo").value.trim();
            var precio = parseFloat(document.getElementById("precio").value);
            var detalles = document.getElementById("detalles").value.trim();
            var unidades = parseInt(document.getElementById("unidades").value);

            if (nombre === "" || nombre.length > 100) {
                alert("El nombre del producto puede tener un máximo de 100 caracteres");
                return false;
            }

            if (marca === "") {
                alert("Debes seleccionar una marca");
                return false;
            }

            if (modelo === "" || modelo.length > 25) {
                alert("El modelo solo puede tener un máximo de 25 caracteres");
                return false;
            }

            if (isNaN(precio) || precio < 99.99) {
                alert("El precio debe ser mayor a $ 99.99");
                return false;
            }

            if (detalles.length > 250) {
                alert("Detalles pueden tener un máximo de 250 caracteres");
                return false;
            }

            if (isNaN(unidades) || unidades < 1) {
                alert("El producto debe tener al menos una unidad en existencia");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>

<h1>Registro de juguetes</h1>

<div class="container-fluid">
    <form action="formulario_productos_v2.php" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario();">
        <fieldset>
            <legend>Información del producto</legend>

            <input type="hidden" name="id" value="<?= isset($id) ? htmlspecialchars($id) : '' ?>">
            
            <div class="form-group">
                <label for="nombre">Nombre del producto:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" 
                value="<?= isset($nombre) ? htmlspecialchars($nombre) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="marca">Marca:</label>
                <select class="form-control" id="marca" name="marca" required>
                    <option value="">Selecciona una marca</option> 
                    <option value="Lego" <?= (isset($marca) && $marca == 'Lego') ? 'selected' : '' ?>>Lego</option>
                    <option value="Fisher Price" <?= (isset($marca) && $marca == 'Fisher Price') ? 'selected' : '' ?>>Fisher Price</option>
                    <option value="Nenuco" <?= (isset($marca) && $marca == 'Nenuco') ? 'selected' : '' ?>>Nenuco</option>
                    <option value="Hasbro" <?= (isset($marca) && $marca == 'Hasbro') ? 'selected' : '' ?>>Hasbro</option>
                    <option value="Mattel" <?= (isset($marca) && $marca == 'Mattel') ? 'selected' : '' ?>>Mattel</option>
                    <option value="Barbie" <?= (isset($marca) && $marca == 'Barbie') ? 'selected' : '' ?>>Barbie</option>
                </select>
            </div>

            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" class="form-control" id="modelo" name="modelo" maxlength="25" 
                value="<?= isset($modelo) ? htmlspecialchars($modelo) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="precio">Precio (MXN):</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" 
                value="<?= isset($precio) ? htmlspecialchars($precio) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="detalles">Detalles (opcional):</label>
                <textarea class="form-control" id="detalles" name="detalles" rows="4" maxlength="250" 
                placeholder="Escribe los detalles del producto"><?= isset($detalles) ? htmlspecialchars($detalles) : '' ?></textarea>
            </div>

            <div class="form-group">
                <label for="unidades">Unidades disponibles:</label>
                <input type="number" class="form-control" id="unidades" name="unidades" min="1" 
                value="<?= isset($unidades) ? htmlspecialchars($unidades) : '' ?>" required>
            </div>

            <div class="form-group">
                <label>Imagen del producto:</label>
                <?php if (isset($imagen) && !empty($imagen)): ?>
                    <img src="<?= htmlspecialchars($imagen) ?>" alt="Imagen del producto" class="img-thumbnail" style="max-width: 200px; height: auto;" />
                <?php else: ?>
                    <img src="img/imagen_defecto.png" alt="Imagen por defecto" class="img-thumbnail" style="max-width: 200px; height: auto;" />
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="imagen_producto">Subir nueva imagen (opcional):</label>
                <input type="file" class="form-control" id="imagen_producto" name="imagen_producto" accept="image/*">
            </div>
        </fieldset>

        <div class="form-group text-center">
            <input type="submit" value="Registrar producto" class="btn btn-success">
            <input type="reset" value="Limpiar" class="btn btn-secondary">
        </div>
    </form>
</div>

<!-- Mostrar mensaje de éxito si se actualizó el producto -->
<?php if (!empty($mensajeExito)): ?>
    <div class="alert alert-success text-center">
        <strong><?= $mensajeExito ?></strong>
    </div>
<?php endif; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
