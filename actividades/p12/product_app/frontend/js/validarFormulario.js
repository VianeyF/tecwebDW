function mostrarError(mensaje) {
    document.getElementById("error-mensaje").textContent = mensaje; // Establece el mensaje de error
    $('#error-modal').modal('show'); // Muestra el modal de Bootstrap
}

function cerrarModal() {
    $('#error-modal').modal('hide'); // Oculta el modal
}

function validarNombre() {
    var nombre = document.getElementById("nombre_producto").value.trim();
    if (nombre === "" || nombre.length > 100) {
        mostrarError("El nombre del producto puede tener un máximo de 100 caracteres");
        return false; // Evitar el paso al siguiente campo
    }
    return true; // Valido
}

function validarMarca() {
    var marca = document.getElementById("marca_producto").value.trim();
    if (marca === "") {
        mostrarError("Debes seleccionar una marca");
        return false;
    }
    return true;
}

function validarModelo() {
    var modelo = document.getElementById("modelo_producto").value.trim();
    if (modelo === "" || modelo.length > 25) {
        mostrarError("El modelo solo puede tener un máximo de 25 caracteres");
        return false;
    }
    return true;
}

function validarPrecio{
    var precio = parseFloat(document.getElementById("precio_producto").value);
    if (isNaN(precio) || precio < 99.99) {
        mostrarError("El precio debe ser mayor a $ 99.99");
        return false;
    }
    return true;
}

function validarDetalles{
    var detalles = document.getElementById("detalles_producto").value.trim();
    if (detalles.length > 250) {
        mostrarError("Detalles pueden tener un maximo de 250 caracteres");
        return false;
    }
    return true;
}

function validarUnidades{
    var unidades = parseInt(document.getElementById("unidades_producto").value);
    if (isNaN(unidades) || unidades < 1) {
        mostrarError("El producto debe tener al menos una unidad en existencia");
        return false;
    }
    return true;
}

$('#product-form').on('submit', function (event) {
    event.preventDefault(); // Evita el envío del formulario si hay errores

    // Ejecuta todas las validaciones
    if (validarNombre() && validarMarca() && validarModelo() && validarPrecio()) {
        alert("Formulario enviado correctamente");
        // Aquí podrías enviar el formulario o procesarlo según sea necesario
    }
});



