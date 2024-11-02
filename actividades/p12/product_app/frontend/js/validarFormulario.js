function mostrarError(mensaje) {
    document.getElementById("error-mensaje").textContent = mensaje; // Establece el mensaje de error
    $('#error-modal').modal('show'); // Muestra el modal de Bootstrap
}

function cerrarModal() {
    $('#error-modal').modal('hide'); // Oculta el modal
}

function validarNombre() {
    var nombreInput = document.getElementById("nombre_producto");
    var nombre = nombreInput.value.trim();
    if (nombre === "" || nombre.length > 100) {
        mostrarError("El nombre del producto no puede estar vacio o tener mas de 100 caracteres");
        nombreInput.focus(); // Regresa el cursor al campo
        return false;
    }
    return true;
}

function validarMarca() {
    var marcaInput = document.getElementById("marca_producto");
    var marca = marcaInput.value.trim();
    if (marca === "") {
        mostrarError("Debes seleccionar una marca");
        marcaInput.focus(); // Regresa el cursor al campo
        return false;
    }
    return true;
}

function validarModelo() {
    var modeloInput = document.getElementById("modelo_producto");
    var modelo = modeloInput.value.trim();
    if (modelo === "" || modelo.length > 25) {
        mostrarError("El modelo solo puede tener un máximo de 25 caracteres");
        modeloInput.focus(); // Regresa el cursor al campo
        return false;
    }
    return true;
}

function validarPrecio() {
    var precioInput = document.getElementById("precio_producto");
    var precio = parseFloat(precioInput.value);
    if (isNaN(precio) || precio < 99.99) {
        mostrarError("El precio debe ser mayor a $99.99");
        precioInput.focus(); // Regresa el cursor al campo
        return false;
    }
    return true;
}

function validarDetalles() {
    var detallesInput = document.getElementById("detalles_producto");
    var detalles = detallesInput.value.trim();
    if (detalles.length > 250) {
        mostrarError("Detalles pueden tener un máximo de 250 caracteres");
        detallesInput.focus(); // Regresa el cursor al campo
        return false;
    }
    return true;
}

function validarUnidades() {
    var unidadesInput = document.getElementById("unidades_producto");
    var unidades = parseInt(unidadesInput.value);
    if (isNaN(unidades) || unidades < 1) {
        mostrarError("El producto debe tener al menos una unidad en existencia");
        unidadesInput.focus(); // Regresa el cursor al campo
        return false;
    }
    return true;
}

// Asignar el evento focusout a cada campo para validación inmediata
document.getElementById("nombre_producto").addEventListener("focusout", validarNombre);
document.getElementById("marca_producto").addEventListener("focusout", validarMarca);
document.getElementById("modelo_producto").addEventListener("focusout", validarModelo);
document.getElementById("precio_producto").addEventListener("focusout", validarPrecio);
document.getElementById("detalles_producto").addEventListener("focusout", validarDetalles);
document.getElementById("unidades_producto").addEventListener("focusout", validarUnidades);

$('#product-form').on('submit', function (event) {
    event.preventDefault(); // Evita el envío del formulario si hay errores

    // Ejecuta todas las validaciones antes de enviar el formulario
    if (validarNombre() && validarMarca() && validarModelo() && validarPrecio() && validarDetalles() && validarUnidades()) {
        alert("Formulario enviado correctamente");
        
        // Lógica para enviar el formulario usando AJAX
        $.ajax({
            url: './backend/product-add-or-update.php', // URL del servidor para procesar el formulario
            method: 'POST',
            data: $('#product-form').serialize(), // Serializa los datos del formulario
            success: function(response) {
                alert("Producto agregado o actualizado exitosamente.");
                $('#product-form')[0].reset(); // Reinicia el formulario tras el envío exitoso
            },
            error: function() {
                mostrarError("Hubo un error al enviar el formulario.");
            }
        });
    } else {
        // Si hay errores, mostrar un mensaje de advertencia general
        mostrarError("Por favor, corrige los errores antes de enviar.");
    }
});

