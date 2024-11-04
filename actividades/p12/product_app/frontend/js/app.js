function init() {
    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();
}

// Función para listar productos
function listarProductos() {
    $.ajax({
        url: './backend/product-list.php',
        method: 'GET',
        success: function (response) {
            let productos = JSON.parse(response);
            let template = '';

            productos.forEach(function (producto) {
                let descripcion = `<li>precio: ${producto.precio}</li>
                                   <li>unidades: ${producto.unidades}</li>
                                   <li>modelo: ${producto.modelo}</li>
                                   <li>marca: ${producto.marca}</li>
                                   <li>detalles: ${producto.detalles}</li>`;

                template += `<tr productId="${producto.id}">
                               <td>${producto.id}</td>
                               <td>${producto.nombre}</td>
                               <td><ul>${descripcion}</ul></td>
                               <td>
                                   <button class="product-delete btn btn-primary mb-2">Eliminar</button>                        
                                   <button class="product-edit btn btn-info mt-2">Editar</button>
                               </td>
                             </tr>`;
            });
            $('#products').html(template);
        }
    });
}

// Función para resaltar coincidencias en la búsqueda
function highlightMatch(text, search) {
    if (!search) return text;
    let regex = new RegExp(`(${search})`, 'gi');
    return text.replace(regex, `<span class="highlight">$1</span>`);
}

// Buscar producto
$('#search-form').on('submit', function (e) {
    e.preventDefault();
    let search = $('#search').val().trim().toLowerCase();
    $.ajax({
        url: './backend/product-search.php',
        method: 'GET',
        data: { search: search },
        success: function (response) {
            let productos = JSON.parse(response);
            let template = '';
            let template_bar = '';

            if (productos.length === 0) {
                template_bar = `<li>No se encontraron productos</li>`;
            } else {
                productos.forEach(function (producto) {
                    let nombre = highlightMatch(producto.nombre, search);
                    let modelo = highlightMatch(producto.modelo, search);
                    let marca = highlightMatch(producto.marca, search);
                    let detalles = highlightMatch(producto.detalles, search);

                    let descripcion = `
                        <li>precio: ${producto.precio}</li>
                        <li>unidades: ${producto.unidades}</li>
                        <li>modelo: ${modelo}</li>
                        <li>marca: ${marca}</li>
                        <li>detalles: ${detalles}</li>`;

                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>`;

                    template_bar += `<li>${nombre}</li>`;
                });
            }

            $('#container').html(template_bar);
            $('#products').html(template);
            document.getElementById("product-result").className = "card my-4 d-block";
        },
        error: function () {
            $('#container').html('<li>Error en la búsqueda</li>');
            document.getElementById("product-result").className = "card my-4 d-block";
        }
    });
});

// Eliminar producto
$(document).on('click', '.product-delete', function () {
    if (confirm("De verdad deseas eliminar el Producto")) {
        let id = $(this).closest('tr').attr('productId');
        $.ajax({
            url: './backend/product-delete.php',
            method: 'GET',
            data: { id: id },
            success: function (response) {
                let respuesta = JSON.parse(response);
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>`;
                document.getElementById("product-result").className = "card my-4 d-block";
                document.getElementById("container").innerHTML = template_bar;

                listarProductos();
            },
            error: function () {
                document.getElementById("container").innerHTML = '<li>Error en la solicitud AJAX</li>';
            }
        });
    }
});

$(document).ready(function () {
    // Validaciones en tiempo real
    $('#nombre_producto, #precio_producto, #unidades_producto, #marca_producto, #modelo_producto, #detalles_producto').on('input', function () {
        validarCampo($(this));
    });
});

// Agregar o actualizar producto con validación completa
$('#product-form').on('submit', function (e) {
    e.preventDefault();

    // Verificar validaciones antes de enviar
    if (validarFormularioCompleto()) {
        $('#product-submit-btn').prop('disabled', true);
        let finalJSON = {
            nombre: $('#nombre_producto').val(),
            precio: $('#precio_producto').val(),
            unidades: $('#unidades_producto').val(),
            marca: $('#marca_producto').val(),
            modelo: $('#modelo_producto').val(),
            detalles: $('#detalles_producto').val(),
            id: $('#productId').val()
        };

        let url = finalJSON.id ? './backend/product-update.php' : './backend/product-add.php';
        console.log(finalJSON);

        $.ajax({
            url: url,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(finalJSON),
            dataType: 'json',
            success: function (response) {
                $('#product-submit-btn').prop('disabled', false);
                if (response.status === 'success') {
                    $('#container').html(`<li style="list-style: none;">status: ${response.status}</li>
                                      <li style="list-style: none;">message: ${response.message}</li>`);
                    document.getElementById("product-result").className = "card my-4 d-block";
                    listarProductos();
                    $('#product-form')[0].reset();
                    $('#productId').val('');
                    $('#product-submit-btn').text('Agregar Producto');
                } else {
                    // Manejar el caso en que no sea exitoso
                    $('#container').html(`<li style="list-style: none;">status: ${response.status}</li>
                                      <li style="list-style: none;">message: ${response.message}</li>`);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud:', textStatus, errorThrown); // Log para depuración
                $('#product-submit-btn').prop('disabled', false);
                mostrarError("Hubo un error al enviar el formulario.");
            }
        });
    } else {

        mostrarError("Por favor, llena los campos requeridos.");
    }
});

// Función de validación de campo
function validarCampo(campo) {
    // Aquí va la lógica para validar cada campo
    let valor = campo.val();
    if (valor === '') {
        campo.addClass('is-invalid');
        campo.removeClass('is-valid');
    } else {
        campo.addClass('is-valid');
        campo.removeClass('is-invalid');
    }
}

// Función para validar el formulario completo
function validarFormularioCompleto() {
    console.log("Todos los campos son válidos, enviando el formulario...");
    let isValid = true;
    $('#nombre_producto, #precio_producto, #unidades_producto, #marca_producto, #modelo_producto, #detalles_producto').each(function () {
        if ($(this).val() === '') {
            isValid = false;
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    return isValid;
}



// Función para editar producto
$(document).on('click', '.product-edit', function () {
    let id = $(this).closest('tr').attr('productId');

    $.ajax({
        url: './backend/product-get.php',
        method: 'GET',
        data: { id: id },
        success: function (response) {
            let producto = JSON.parse(response);

            // Cargar los datos en los campos del formulario
            $('#nombre_producto').val(producto.nombre);
            $('#precio_producto').val(producto.precio);
            $('#unidades_producto').val(producto.unidades);
            $('#marca_producto').val(producto.marca);
            $('#modelo_producto').val(producto.modelo);
            $('#detalles_producto').val(producto.detalles);
            $('#productId').val(producto.id);

            // Cambiar el botón a "Actualizar Producto"
            $('#product-submit-btn').text('Actualizar Producto');
        },
        error: function () {
            console.log('Error al obtener la información del producto.');
        }
    });
});
