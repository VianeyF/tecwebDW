<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;



use Gonza\P13\Create\Create as Create;
use Gonza\P13\Delete\Delete as Delete;  
use Gonza\P13\Update\update as update; 
use Gonza\P13\Read\Read as Read; 

require_once __DIR__ . '/../vendor/autoload.php';

// Crear la aplicación
$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->setBasePath("/tecweb/practicas/p18/psr-4/backend");
$app->addErrorMiddleware(true, true, true);


// Ruta para obtener todos los productos (GET)
$app->get('/product-list', function ($request, $response, $args) {
    try {
        $productos = new Read('marketzone');
        $productos->list();  // Listar productos desde la base de datos
        $data = json_decode($productos->getData());
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    } catch (Exception $e) {
        return $response->withJson(["error" => "Error al obtener los productos: " . $e->getMessage()], 500);
    }
});
// Ruta POST para agregar un producto
$app->post('/product-add', function (Request $request, Response $response, $args) {
    try {
        $data = $request->getBody();
        $productos = new Create('marketzone');
        $productos->add($data); // Agregar el producto
        $responseData = $productos->getData();
        $response->getBody()->write(json_encode($responseData)); // Escribe el cuerpo de la respuesta con los datos en formato JSON

        return $response->withHeader('Content-Type', 'application/json'); 
    } catch (Exception $e) {
        return $response->withJson(["error" => "Error al agregar los productos: " . $e->getMessage()], 500);
    }
});

// Ruta GET para buscar productos
$app->get('/product-search', function (Request $request, Response $response, $args) {
    try {
        // Obtener el parámetro 'search' desde la URL
        $searchTerm = $request->getQueryParams()['search'] ?? '';
        $productos = new Read('marketzone');
        $productos->search($searchTerm);
        $responseData = json_decode($productos->getData(), true);
        $response->getBody()->write(json_encode($responseData));
        return $response->withHeader('Content-Type', 'application/json');
    } catch (Exception $e) {
        // Manejo de errores
        return $response->withJson(["error" => "Error al realizar la búsqueda: " . $e->getMessage()], 500);
    }
});

// Ruta POST para actualizar un producto
$app->post('/product-update', function (Request $request, Response $response, $args) {
    try {
        $data = $request->getBody();
        $productos = new Update('marketzone');
        $productos->edit($data);
        $responseData = json_decode($productos->getData(), true);
        $response->getBody()->write(json_encode($responseData));
        return $response->withHeader('Content-Type', 'application/json');
    } catch (Exception $e) {
        // Manejo de errores
        return $response->withJson(["error" => "Error al actualizar el producto: " . $e->getMessage()], 500);
    }
});

// Ruta GET para obtener un producto por nombre
$app->get('/product-search-name', function (Request $request, Response $response, $args) {
    try {
        $nombre = $request->getQueryParams()['nombre'] ?? '';
        $productos = new Read('marketzone');
        $productos->singleByName($nombre);
        
        // Usamos el valor de `data` como la respuesta
        $responseData = $productos->getData(); 
        $response->getBody()->write($responseData); 
        return $response->withHeader('Content-Type', 'application/json');
    } catch (Exception $e) {
        return $response->withJson(["error" => "Error al obtener el producto: " . $e->getMessage()], 500);
    }
});
// Ruta POST para obtener un producto por su ID
$app->post('/product-single', function (Request $request, Response $response, $args) {
    try {
        // Obtener el ID del cuerpo de la solicitud
        $parsedBody = $request->getParsedBody();
        $id = $parsedBody['id'] ?? null;
        $productos = new Read('marketzone');
        $productos->single($id);
        $data = json_decode($productos->getData(), true);
        $response->getBody()->write(json_encode($data));

        return $response->withHeader('Content-Type', 'application/json');
    } catch (Exception $e) {
        // Manejo de errores
        return $response->withJson(["error" => "Error al obtener el producto: " . $e->getMessage()], 500);
    }
});
//Ruta GET para borrar un producto por su ID
$app->get('/product-delete', function (Request $request, Response $response, $args) {
    try {
        $id = $request->getQueryParams()['id'] ?? '';
        $productos = new Delete('marketzone');
        $productos->delet($id);
        $responseData = $productos->getData(); 
        $response->getBody()->write($responseData); 
        return $response->withHeader('Content-Type', 'application/json');
    } catch (Exception $e) {
        return $response->withJson(["error" => "Error al obtener el producto: " . $e->getMessage()], 500);
    }
});

$app->run();