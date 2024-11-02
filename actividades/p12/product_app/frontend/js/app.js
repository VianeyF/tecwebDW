// JSON BASE A MOSTRAR EN FORMULARIO
function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON, null, 2);
    document.getElementById("description").value = JsonString;

    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();
}
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

function highlightMatch(text, search) {
    // Si no hay término de búsqueda o no coincide, devolvemos el texto original
    if (!search) return text;
    console.log("Resaltando coincidencias para:", search); // Agregamos este log
    let regex = new RegExp(`(${search})`, 'gi'); // Expresión regular para búsqueda insensible a mayúsculas
    let highlightedText = text.replace(regex, `<span class="highlight">$1</span>`); // Resaltamos el texto
    console.log("Texto resaltado:", highlightedText); // Mostramos el texto resaltado en consola
    return highlightedText; // Devolvemos el texto resaltado
}

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

// Función para editar producto
$(document).on('click', '.product-edit', function () {
    let id = $(this).closest('tr').attr('productId');
    $.ajax({
        url: './backend/product-get.php',
        method: 'GET',
        data: { id: id },
        success: function (response) {
            let producto = JSON.parse(response);

            // Cargar los datos en el formulario
            $('#name').val(producto.nombre);
            $('#description').val(JSON.stringify(producto, null, 2));
            $('#productId').val(producto.id); // Guardamos el ID en un campo oculto

            // Cambiar el botón de agregar por "Actualizar"
            //$('button[type="submit"]').text('Actualizar Producto');
            $('#product-submit-btn').text('Actualizar Producto');
        }
    });
});

// Modificación del formulario para manejar la actualización
$('#product-form').on('submit', function (e) {
    e.preventDefault();
    let productoJsonString = $('#description').val();
    let finalJSON = JSON.parse(productoJsonString);
    finalJSON['nombre'] = $('#name').val();




    let productId = $('#productId').val(); // Obtenemos el ID del producto (si existe)
    let url = productId ? './backend/product-update.php' : './backend/product-add.php';

    $.ajax({
        url: url,
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(finalJSON),
        success: function (response) {
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

            // Reiniciar el formulario
            $('#product-form')[0].reset();
            $('#productId').val(''); // Limpiamos el campo oculto
            //$('button[type="submit"]').text('Agregar Producto'); // Volvemos a cambiar el botón
            $('#product-submit-btn').text('Actualizar Producto');

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