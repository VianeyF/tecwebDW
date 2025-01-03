
$(document).ready(function () {
    // Inicializa el formulario y lista los productos
    init();
    let edit = false;
    // Función para listar productos 
    function listarProductos() {
        
        $.ajax({
            url: 'http://localhost/tecweb/practicas/p18/psr-4/backend/product-list',
            method: 'GET',
            dataType: 'json',
            success: function (productos) {
                if (typeof productos === "string") {
                    productos = JSON.parse(productos);
                }
                let template = '';
                productos.forEach(function (producto) {
                    let descripcion = `
                        <li>precio: ${producto.precio}</li>
                        <li>unidades: ${producto.unidades}</li>
                        <li>modelo: ${producto.modelo}</li>
                        <li>marca: ${producto.marca}</li>
                        <li>detalles: ${producto.detalles}</li>
                    `;
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td><a href="#" class="product-item"> ${producto.nombre} </a></td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });
                $('#products').html(template); // Actualiza la tabla de productos
            }
        });
    }

    // Inicializa el formulario y lista los productos
    function init() {
        listarProductos(); // Lista productos al iniciar
    }

    // Función para buscar productos
    $('#busqueda-form').submit(function (e) {
        e.preventDefault(); // Evita el comportamiento por defecto del formulario

        let search = $('#search').val(); // Obtiene el valor del campo de búsqueda

        $.ajax({
            url: 'http://localhost/tecweb/practicas/p18/psr-4/backend/product-search',
            method: 'GET',
            data: { search: search },
            dataType: 'json',
            success: function (productos) {
                if (typeof productos === 'string') {
                    productos = JSON.parse(productos);  // Convierte la cadena JSON en un objeto
                }
                let template = '';
                let template_bar = '';

                productos.forEach(function (producto) {
                    let descripcion = `
                        <li>precio: ${producto.precio}</li>
                        <li>unidades: ${producto.unidades}</li>
                        <li>modelo: ${producto.modelo}</li>
                        <li>marca: ${producto.marca}</li>
                        <li>detalles: ${producto.detalles}</li>
                    `;
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    `;
                    template_bar += `<li>${producto.nombre}</li>`;
                });

                $('#container').html(template_bar); // Actualiza la barra de resultados
                $('#products').html(template); // Actualiza la tabla de productos
            }
        });
    });
    
    // Función para buscar productos con KEYUP
    $('#search').keyup(function (e) {
        e.preventDefault(); // Evita el comportamiento por defecto del formulario

        let search = $('#search').val(); // Obtiene el valor del campo de búsqueda

        $.ajax({
            url: 'http://localhost/tecweb/practicas/p18/psr-4/backend/product-search',
            method: 'GET',
            data: { search: search },
            dataType: 'json',
            success: function (productos) {
                if (typeof productos === 'string') {
                    productos = JSON.parse(productos);  // Convierte la cadena JSON en un objeto
                }

                let template = '';
                let template_bar = '';

                productos.forEach(function (producto) {
                    
                    let descripcion = `
                        <li>precio: ${producto.precio}</li>
                        <li>unidades: ${producto.unidades}</li>
                        <li>modelo: ${producto.modelo}</li>
                        <li>marca: ${producto.marca}</li>
                        <li>detalles: ${producto.detalles}</li>
                    `;
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    `;
                    template_bar += `<li>${producto.nombre}</li>`;
                });

                $('#container').html(template_bar); // Actualiza la barra de resultados
                $('#product-result').removeClass('d-none').addClass('d-block');
                $('#products').html(template); // Actualiza la tabla de productos
            }
        });
    });


    // Función para agregar producto
    $('#product-form').submit( function (e) {
        e.preventDefault();    
        let finalJSON = {};
        finalJSON['nombre'] = $('#name').val();
        finalJSON['marca'] = $('#marca').val();
        finalJSON['modelo'] = $('#modelo').val();
        finalJSON['precio'] = $('#precio').val();
        finalJSON['detalles'] = $('#detalles').val();
        finalJSON['unidades'] = $('#unidades').val();
        finalJSON['imagen'] = $('#imagen').val();
        finalJSON['id'] = $('#productId').val();
        console.log(finalJSON);


        // Verifica que todos los campos obligatorios estén llenos
        if (!validarCamposVacios(finalJSON)) {
            $('#container').html('Por favor, llena todos los campos requeridos.');
            $('#product-result').removeClass('d-none').addClass('d-block');
            return; // Detiene el envío si faltan datos
        }

        if (!validarJSON(finalJSON)) {
            $('#container').html('Por favor, llena todos los campos requeridos segun el formato.');
            $('#product-result').removeClass('d-none').addClass('d-block');
            return; // Detiene el envío si faltan datos
        }

        // Enviamos el JSON al servidor
        const url = edit === false ? 'http://localhost/tecweb/practicas/p18/psr-4/backend/product-add' : 'http://localhost/tecweb/practicas/p18/psr-4/backend/product-update';
        console.log(url);
        
        $.ajax({
            url: url,
            method: 'POST',
            data: JSON.stringify(finalJSON),
            contentType: 'application/json;charset=UTF-8',
            success: function (productos) {
                console.log(productos);
                // Si la productos es una cadena, conviértela en un objeto JSON
                if (typeof productos === 'string') {
                    productos = JSON.parse(productos);  // Convierte la cadena JSON en un objeto
                }
                console.log("holaq");
                console.log(productos); // Verifica la productos recibida
                let template_bar = '';
                template_bar += `
                            <li style="list-style: none;">status: ${productos.status}</li>
                            <li style="list-style: none;">message: ${productos.message}</li>
                        `;  
                  
                $('#container').html(template_bar); // Actualiza la barra de resultados
                $('#product-result').removeClass('d-none').addClass('d-block');

                // Limpiar todos los campos del formulario
                $('#product-form')[0].reset();

                // Recarga la lista de productos
                listarProductos();
            }
        });
    });
    

    
    // Función para eliminar producto
    $(document).on('click', '.product-delete', function () {
        if (confirm('De verdad deseas eliminar el Producto?')) {
            let id = $(this).closest('tr').attr('productId');

            $.ajax({
                url: 'http://localhost/tecweb/practicas/p18/psr-4/backend/product-delete',
                method: 'GET',
                data: { id: id },
                success: function (productos) {
                    // Si la productos es una cadena, conviértela en un objeto JSON
                    if (typeof productos === 'string') {
                        productos = JSON.parse(productos); // Convierte la cadena JSON en un objeto
                    }
                    let template_bar = `
                        <li style="list-style: none;">status: ${productos.status}</li>
                        <li style="list-style: none;">message: ${productos.message}</li>
                    `;
                    $('#container').html(template_bar); // Actualiza la barra de resultados
                    $('#product-result').removeClass('d-none').addClass('d-block');

                    // Recarga la lista de productos
                    listarProductos();
                }
            });
        }
    });

    // Obtener un producto por ID
    $(document).on('click', '.product-item', (e) => {
        const element = e.currentTarget.closest('tr'); // Encuentra el elemento <tr> más cercano
        const id = $(element).attr('productId'); // Obtiene el productId del atributo
        console.log(id);
        $.post('http://localhost/tecweb/practicas/p18/psr-4/backend/product-single', { id }, (response) => {
            try {
                const producto = typeof response === 'string' ? JSON.parse(response) : response;
                console.log(producto); // Revisa el contenido
                $('#name').val(producto.nombre); 
                $('#precio').val(producto.precio); 
                $('#unidades').val(producto.unidades); 
                $('#modelo').val(producto.modelo); 
                $('#marca').val(producto.marca); 
                $('#imagen').val(producto.imagen); 
                $('#detalles').val(producto.detalles); 
                $('#productId').val(producto.id); 
                edit = true; // Activa la edición
            } catch (error) {
                console.error("Error al analizar JSON:", error, response);
            }
        });

        e.preventDefault(); // Previene la acción por defecto del enlace
    });

    // Validar los campos al perder el foco
    $('#name, #marca, #modelo, #precio, #detalles, #unidades, #imagen').on('blur', function() {
        // Crear el objeto JSON final dentro de la función de validación
        let finalJSON = {};
        finalJSON['nombre'] = $('#name').val();
        finalJSON['marca'] = $('#marca').val();
        finalJSON['modelo'] = $('#modelo').val();
        finalJSON['precio'] = $('#precio').val();
        finalJSON['detalles'] = $('#detalles').val();
        finalJSON['unidades'] = $('#unidades').val();
        finalJSON['imagen'] = $('#imagen').val();

        // Llamar a la función de validación
        validarJSON(finalJSON);
    });

    // Evento para validar el nombre del producto al teclear
    $('#name').on('input', function() {
        const nombre = $(this).val().trim(); // Obtener el valor del campo y quitar espacios

        if (nombre.length === 0) {
            $('#product-result').removeClass('d-block').addClass('d-none');
            return;
        }
        console.log(nombre);
        // Realizar la llamada AJAX para verificar si el nombre ya existe
        $.ajax({
            url: 'http://localhost/tecweb/practicas/p18/psr-4/backend/product-search-name', 
            method: 'GET',
            data:{ nombre: nombre },
            dataType: 'json',
            success: function(productos) {
                console.log(productos);
                if (typeof productos === 'string') {
                    productos = JSON.parse(productos); // Convierte la cadena JSON en un objeto
                }
                // Mostrar el mensaje de error si el nombre ya existe
                if (productos.exists) {
                    $('#container').html('El nombre del producto ya existe.');
                    $('#product-result').removeClass('d-none').addClass('d-block');
                } else {
                    $('#container').html('Ningun producto existente en la base de datos coincide.'); // Limpiar mensaje de error si no existe
                    $('#product-result').removeClass('d-none').addClass('d-block');
                }
            },
            error: function() {
                // Manejar errores en la llamada AJAX
                $('#container').text('Error al validar el nombre del producto.'); // Mensaje de error
            }
        });
    });


function validarCamposVacios(json) {
    for (let key in json) {
        if (key !== 'imagen' && key !== 'id' && (!json[key] || json[key].trim() === '')) {
            return false; // Si algún campo está vacío, retorna falso
        }
    }
    return true; // Si todos los campos están llenos, retorna verdadero
}

   // FUNCIÓN DE VALIDACIÓN 
    function validarJSON(producto) {
          // Limpiar los contenedores de errores al inicio
        $('#container-name').html("");
        $('#progress-name').removeClass('d-block').addClass('d-none');

        $('#container-marca').html("");
        $('#progress-marca').removeClass('d-block').addClass('d-none');

        $('#container-modelo').html("");
        $('#progress-modelo').removeClass('d-block').addClass('d-none');

        $('#container-precio').html("");
        $('#progress-precio').removeClass('d-block').addClass('d-none');

        $('#container-units').html("");
        $('#progress-units').removeClass('d-block').addClass('d-none');

        $('#container').html('');
        $('#product-result').removeClass('d-block').addClass('d-none');
       
        // Validar Nombre
        if (!producto.nombre || producto.nombre.trim() === "" || producto.nombre.length > 100) {
            $('#container-name').html("El nombre es requerido y debe tener 100 caracteres o menos."); 
            $('#progress-name').removeClass('d-none').addClass('d-block');
            return false;
        }

        // Validar Marca
        if (!producto.marca || producto.marca.trim() === "") {
            $('#container-marca').html("La marca es requerida y debe seleccionarse de lista."); 
            $('#progress-marca').removeClass('d-none').addClass('d-block');
            return false;
        }
        // Validar Modelo
        if (!producto.modelo || producto.modelo.trim() === "" || !/^[a-zA-Z0-9]+$/.test(producto.modelo) || producto.modelo.length > 25) {
            $('#container-modelo').html("El modelo es requerido, debe ser alfanumérico y tener 25 caracteres o menos."); 
            $('#progress-modelo').removeClass('d-none').addClass('d-block');
            return false;
        }

        // Validar Precio
        if (isNaN(producto.precio) || producto.precio <= 99.99) {
            $('#container-precio').html("El precio es requerido y debe ser mayor a 99.99."); 
            $('#progress-precio').removeClass('d-none').addClass('d-block');
            return false;
        }

        // Validar Detalles
        if (producto.detalles && producto.detalles.length > 250) {
            $('#container-detalles').html("Los detalles deben tener 250 caracteres o menos."); 
            $('#progress-detalles').removeClass('d-none').addClass('d-block');
        }

        // Validar Unidades
        if (isNaN(producto.unidades) || producto.unidades <= 0) {
            $('#container-units').html("Las unidades son requeridas y deben ser mayor o igual a 0."); 
            $('#progress-units').removeClass('d-none').addClass('d-block');
            return false;
        }
        // Validar Imagen
        if (!producto.imagen || producto.imagen.trim() === "") {
            producto.imagen = "img/image.png"; // Asignar imagen por defecto
        }

        
        $('#container').html('Datos Correctos.');
        $('#product-result').removeClass('d-none').addClass('d-block');
        return true; 
    }

   
});
