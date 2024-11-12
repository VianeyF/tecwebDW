function mostrarError(mensaje) {
    document.getElementById("error-mensaje").textContent = mensaje;
    $('#error-modal').modal('show');
}

function cerrarModal() {
    $('#error-modal').modal('hide');
}

// Funciones de validación individual
function validarNombre() {
    var nombreInput = document.getElementById("nombre_producto");
    var nombre = nombreInput.value.trim();
    if (nombre === "" || nombre.length > 100) {
        mostrarError("El nombre del producto no puede estar vacío o tener más de 100 caracteres");
        $(nombreInput).removeClass("is-valid").addClass("is-invalid");
        return false;
    }
    $(nombreInput).removeClass("is-invalid").addClass("is-valid");
    return true;
}

function validarMarca() {
    var marcaInput = document.getElementById("marca_producto");
    var marca = marcaInput.value.trim();
    if (marca === "") {
        mostrarError("Debes seleccionar una marca");
        $(marcaInput).removeClass("is-valid").addClass("is-invalid");
        return false;
    }
    $(marcaInput).removeClass("is-invalid").addClass("is-valid");
    return true;
}

function validarModelo() {
    var modeloInput = document.getElementById("modelo_producto");
    var modelo = modeloInput.value.trim();
    if (modelo === "" || modelo.length > 25) {
        mostrarError("El modelo solo puede tener un máximo de 25 caracteres y no puede estar vacío");
        $(modeloInput).removeClass("is-valid").addClass("is-invalid");
        return false;
    }
    $(modeloInput).removeClass("is-invalid").addClass("is-valid");
    return true;
}

function validarPrecio() {
    var precioInput = document.getElementById("precio_producto");
    var precio = parseFloat(precioInput.value);
    if (isNaN(precio) || precio <= 99.99) {
        mostrarError("El precio debe ser un número mayor a $99.99");
        $(precioInput).removeClass("is-valid").addClass("is-invalid");
        return false;
    }
    $(precioInput).removeClass("is-invalid").addClass("is-valid");
    return true;
}

function validarDetalles() {
    var detallesInput = document.getElementById("detalles_producto");
    var detalles = detallesInput.value.trim();
    if (detalles.length > 250) {
        mostrarError("Los detalles pueden tener un máximo de 250 caracteres");
        $(detallesInput).removeClass("is-valid").addClass("is-invalid");
        return false;
    }
    $(detallesInput).removeClass("is-invalid").addClass("is-valid");
    return true;
}

function validarUnidades() {
    var unidadesInput = document.getElementById("unidades_producto");
    var unidades = parseInt(unidadesInput.value);
    if (isNaN(unidades) || unidades < 1) {
        mostrarError("El producto debe tener al menos una unidad en existencia");
        $(unidadesInput).removeClass("is-valid").addClass("is-invalid");
        return false;
    }
    $(unidadesInput).removeClass("is-invalid").addClass("is-valid");
    return true;
}

// Validación completa del formulario
function validarFormularioCompleto() {
    return validarNombre() && validarMarca() && validarModelo() && validarPrecio() && validarUnidades() && validarDetalles();
}

// Eventos focusout para cada campo
document.getElementById("nombre_producto").addEventListener("focusout", validarNombre);
document.getElementById("marca_producto").addEventListener("focusout", validarMarca);
document.getElementById("modelo_producto").addEventListener("focusout", validarModelo);
document.getElementById("precio_producto").addEventListener("focusout", validarPrecio);
document.getElementById("detalles_producto").addEventListener("focusout", validarDetalles);
document.getElementById("unidades_producto").addEventListener("focusout", validarUnidades);
