// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

// Función para agregar producto
function agregarProducto(e) {
    e.preventDefault();

    // Obtener los valores del formulario
    let nombre = document.getElementById('nombre').value.trim();
    let marca = document.getElementById('marca').value.trim();
    let modelo = document.getElementById('modelo').value.trim();
    let precio = parseFloat(document.getElementById('precio').value);
    let unidades = parseInt(document.getElementById('unidades').value);
    let detalles = document.getElementById('detalles').value.trim();
    let imagen = document.getElementById('imagen').value.trim() || 'img/default.png';


    console.log('Nombre:', nombre); // Verificar el valor del nombre

    // Validaciones
    if (nombre.length === 0 || nombre.length > 100) {
        alert('El nombre debe tener entre 1 y 100 caracteres.');
        return;
    }
    if (!marca) {
        alert('La marca es requerida.');
        return;
    }
    if (!modelo || !/^[a-zA-Z0-9\-]+$/.test(modelo) || modelo.length > 25) {
        alert('El modelo debe ser alfanumerico y tener 25 caracteres o menos.');
        return;
    }
    if (isNaN(precio) || precio <= 99.99) {
        alert('El precio debe ser mayor a 99.99.');
        return;
    }
    if (detalles && detalles.length > 250) {
        alert('Los detalles deben tener 250 caracteres o menos.');
        return;
    }
    if (isNaN(unidades) || unidades < 1) {
        alert('Las unidades deben ser mayores o iguales a 1.');
        return;
    }

    // Crear objeto JSON para enviar
    let producto = {
        nombre: nombre,
        marca: marca,
        modelo: modelo,
        precio: precio,
        unidades: unidades,
        detalles: detalles,
        imagen: imagen
    };

    // Enviar el producto al servidor
    let client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    client.onreadystatechange = function () {
        if (client.readyState == 4) {
            if (client.status == 200) {
                alert(client.responseText);  // Mostrar mensaje del servidor
            } else {
                alert('Error al agregar el producto: ' + client.statusText);
            }
        }
    };
    client.send(JSON.stringify(producto));
}

// Función para buscar producto por ID
function buscarID(e) {
    e.preventDefault();
    var id = document.getElementById('searchID').value;
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            let productos = JSON.parse(client.responseText);
            if (Object.keys(productos).length > 0) {
                let descripcion = '';
                descripcion += '<li>precio: ' + productos.precio + '</li>';
                descripcion += '<li>unidades: ' + productos.unidades + '</li>';
                descripcion += '<li>modelo: ' + productos.modelo + '</li>';
                descripcion += '<li>marca: ' + productos.marca + '</li>';
                descripcion += '<li>detalles: ' + productos.detalles + '</li>';

                let template = `
                    <tr>
                        <td>${productos.id}</td>
                        <td>${productos.nombre}</td>
                        <td><ul>${descripcion}</ul></td>
                    </tr>`;
                document.getElementById("productos").innerHTML = template;
            }
        }
    };
    client.send("id=" + encodeURIComponent(id));
}

// Función para buscar producto por nombre, marca o detalles
function buscarProductoPlus(e) {
    e.preventDefault();
    var search_term = document.getElementById('searchTerm').value;
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            let productos = JSON.parse(client.responseText);
            if (productos.length > 0) {
                let template = '';
                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>precio: ' + producto.precio + '</li>';
                    descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                    descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                    descripcion += '<li>marca: ' + producto.marca + '</li>';
                    descripcion += '<li>detalles: ' + producto.detalles + '</li>';

                    template += `
                        <tr>
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>`;
                });
                document.getElementById("productos").innerHTML = template;
            } else {
                document.getElementById("productos").innerHTML = "<tr><td colspan='3'>No se encontraron productos</td></tr>";
            }
        }
    };
    client.send("search_term=" + encodeURIComponent(search_term));
}

// Inicialización
function init() {
    var JsonString = JSON.stringify(baseJSON, null, 2);
    document.getElementById("description").value = JsonString;
}

// Se crea el objeto de conexión compatible con el navegador
function getXMLHttpRequest() {
    var objetoAjax;
    try {
        objetoAjax = new XMLHttpRequest();
    } catch (err1) {
        try {
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (err2) {
            try {
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (err3) {
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}
