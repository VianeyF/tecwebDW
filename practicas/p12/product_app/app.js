// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
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
                                   <button class="product-delete btn btn-danger">Eliminar</button>
                               </td>
                             </tr>`;
            });
            $('#products').html(template);
        }
    });
}

$('#search-form').on('submit', function (e) {
    e.preventDefault();
    let search = $('#search').val();

    $.ajax({
        url: './backend/product-search.php',
        method: 'GET',
        data: { search: search },
        success: function (response) {
            let productos = JSON.parse(response);
            let template = '';
            let template_bar = '';

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
                                   <button class="product-delete btn btn-danger">Eliminar</button>
                               </td>
                             </tr>`;

                template_bar += `<li>${producto.nombre}</li>`;
            });

            $('#container').html(template_bar);
            $('#products').html(template);
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
            let template_bar = `<li>status: ${respuesta.status}</li>
                                <li>message: ${respuesta.message}</li>`;
            $('#container').html(template_bar);
            listarProductos();
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
                let template_bar = `<li>status: ${respuesta.status}</li>
                                    <li>message: ${respuesta.message}</li>`;
                $('#container').html(template_bar);
                listarProductos();
            }
        });
    }
});