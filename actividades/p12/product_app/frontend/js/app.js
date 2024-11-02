function init() {
    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();
}

/*Listar productos
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
}*/

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

//iluminar busqueda
function highlightMatch(text, search) {
    // Si no hay término de búsqueda o no coincide, devolvemos el texto original
    if (!search) return text;
    console.log("Resaltando coincidencias para:", search); // Agregamos este log
    let regex = new RegExp(`(${search})`, 'gi'); // Expresión regular para búsqueda insensible a mayúsculas
    let highlightedText = text.replace(regex, `<span class="highlight">$1</span>`); // Resaltamos el texto
    console.log("Texto resaltado:", highlightedText); // Mostramos el texto resaltado en consola
    return highlightedText; // Devolvemos el texto resaltado
}

//Buscar proucto
$('#search-form').on('submit', function (e) {
    e.preventDefault();
    let search = $('#search').val().trim().toLowerCase();
    console.log("Valor de búsqueda:", search); // Para verificar que se obtiene el valor
    $.ajax({
        url: './backend/product-search.php',
        method: 'GET',
        data: { search: search },
        success: function (response) {
            console.log("Respuesta del servidor:", response); // Para verificar la respuesta
            let productos = JSON.parse(response);
            let template = '';
            let template_bar = '';

            if (productos.length === 0) {
                template_bar = `<li>No se encontraron productos</li>`;
            } else {
                productos.forEach(function (producto) {
                    let id = highlightMatch(producto.id.toString(), search);
                    let nombre = highlightMatch(producto.nombre, search);
                    let modelo = highlightMatch(producto.modelo, search);
                    let marca = highlightMatch(producto.marca, search);
                    let detalles = highlightMatch(producto.detalles, search);

                    let descripcion = `
                        <li>precio: ${producto.precio}</li>
                        <li>unidades: ${producto.unidades}</li>
                        <li>modelo: ${modelo}</li>  <!-- Aplicando el resaltado aquí -->
                        <li>marca: ${marca}</li>    <!-- Aplicando el resaltado aquí -->
                        <li>detalles: ${detalles}</li>`;

                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${nombre}</td>  <!-- Aplicando el resaltado aquí -->
                            <td><ul>${descripcion}</ul></td>
                        </tr>`;

                    template_bar += `<li>${nombre}</li>`;
                });
            }

            console.log(template); // Verificamos que el HTML generado contenga las etiquetas <span>
            $('#container').html(template_bar);
            $('#products').html(template);

            // SE HACE VISIBLE LA BARRA DE ESTADO
            document.getElementById("product-result").className = "card my-4 d-block";
        },
        error: function (error) {
            console.error("Error en la búsqueda:", error); // Verificar errores
            let template_bar = `<li>Error en la búsqueda</li>`;
            $('#container').html(template_bar);
            // SE HACE VISIBLE LA BARRA DE ESTADO
            document.getElementById("product-result").className = "card my-4 d-block";
        }
    });
});

//Borrar producto
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
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                // SE HACE VISIBLE LA BARRA DE ESTADO
                document.getElementById("product-result").className = "card my-4 d-block";
                // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                document.getElementById("container").innerHTML = template_bar;

                listarProductos();
            },
            error: function () {
                let template_bar = `
                    <li style="list-style: none;">status: error</li>
                    <li style="list-style: none;">message: Error en la solicitud AJAX</li>
                `;
                document.getElementById("container").innerHTML = template_bar;
            }
        });
    }
});

//Agregar producto
$('#product-form').on('submit', function (e) {
    e.preventDefault();
    let productoJsonString = $('#description').val();
    let finalJSON = JSON.parse(productoJsonString);
    finalJSON['nombre'] = $('#name').val();
    $.ajax({
        url: './backend/product-add.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(finalJSON),
        success: function (response) {
            let respuesta = JSON.parse(response);
            let template_bar = `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            // SE HACE VISIBLE LA BARRA DE ESTADO
            document.getElementById("product-result").className = "card my-4 d-block";
            // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
            document.getElementById("container").innerHTML = template_bar;

            listarProductos();
        },
        error: function () {
            let template_bar = `
                <li style="list-style: none;">status: error</li>
                <li style="list-style: none;">message: Error en la solicitud AJAX</li>
            `;
            document.getElementById("container").innerHTML = template_bar;
        }
    });
});

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

// Evento de envío del formulario
$('#product-form').on('submit', function (e) {
    e.preventDefault();

    // Creamos el JSON directamente desde los campos del formulario
    let finalJSON = {
        nombre: $('#nombre_producto').val(),
        precio: $('#precio_producto').val(),
        unidades: $('#unidades_producto').val(),
        marca: $('#marca_producto').val(),
        modelo: $('#modelo_producto').val(),
        detalles: $('#detalles_producto').val(),
        id: $('#productId').val() // Usar este campo para determinar si es una actualización
    };

    // Determinamos la URL en función de si es una actualización o una adición
    let url = finalJSON.id ? './backend/product-update.php' : './backend/product-add.php';

    $.ajax({
        url: url,
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(finalJSON),
        success: function (response) {
            try {
                let respuesta = JSON.parse(response);
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;

                // Actualizamos la barra de estado
                document.getElementById("product-result").className = "card my-4 d-block";
                document.getElementById("container").innerHTML = template_bar;

                // Volver a listar los productos
                listarProductos();

                // Reiniciar el formulario y cambiar el botón a "Agregar Producto"
                $('#product-form')[0].reset();
                $('#productId').val('');
                $('#product-submit-btn').text('Agregar Producto');
            } catch (error) {
                console.error("Error al parsear la respuesta JSON:", error);
                console.log("Respuesta recibida:", response);
            }
        },
        error: function () {
            let template_bar = `
                <li style="list-style: none;">status: error</li>
                <li style="list-style: none;">message: Error en la solicitud AJAX</li>
            `;
            document.getElementById("container").innerHTML = template_bar;
        }
    });
});
