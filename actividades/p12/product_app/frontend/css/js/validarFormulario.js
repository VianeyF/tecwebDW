function validarFormulario() {
    var nombre = document.getElementById("nombre_producto").value.trim();
    var marca = document.getElementById("marca_producto").value.trim();
    var modelo = document.getElementById("modelo_producto").value.trim();
    var precio = parseFloat(document.getElementById("precio_producto").value);
    var detalles = document.getElementById("detalles_producto").value.trim();
    var unidades = parseInt(document.getElementById("unidades_producto").value);

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
        alert("Detalles pueden tener un maximo de 250 caracteres");
        return false;
    }

    if (isNaN(unidades) || unidades < 1) {
        alert("El producto debe tener al menos una unidad en existencia");
        return false;
    }

    return true;
}