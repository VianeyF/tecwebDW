<?php
namespace MyApi;

require_once __DIR__ . '/DataBase.php';

use PDO;
use PDOException;

class Products extends DataBase
{
    // Atributo para almacenar la respuesta
    protected $data = [];

    // Constructor que recibe el nombre de la base de datos y llama al constructor de la clase padre
    public function __construct($dbname = 'marketzone', $host = 'localhost', $user = 'root', $password = 'vianey24')
    {
        // Llamada al constructor de la clase padre para inicializar la conexión
        parent::__construct($host, $dbname, $user, $password);
        // Inicialización del atributo 'data'
        $this->data = [];
    }

    // Método para buscar un producto por su nombre
    public function singleByName($productName)
    {
        try {
            $stmt = $this->conexion->prepare('SELECT * FROM productos WHERE nombre = :nombre');
            $stmt->bindParam(':nombre', $productName);
            $stmt->execute();
            $this->data = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            $this->data = ['error' => $e->getMessage()];
        }
    }

    // Método para obtener los datos como un JSON
    public function getData()
    {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }

    // Método para obtener todos los productos
    public function getAllProducts()
    {
        try {
            $stmt = $this->conexion->query('SELECT * FROM productos WHERE eliminado = 0');
            $this->data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->data = ['error' => $e->getMessage()];
        }
    }

     // Método para eliminar un producto por su ID
     public function deleteProduct($id)
     {
         try {
             // Consulta SQL para eliminar el producto
             $sql = 'UPDATE productos SET eliminado = 1 WHERE id = :id';
             $stmt = $this->conexion->prepare($sql);
             $stmt->bindParam(':id', $id, PDO::PARAM_INT);
             if ($stmt->execute()) {
                 return ['status' => 'success', 'message' => 'Producto eliminado'];
             } else {
                 return ['status' => 'error', 'message' => 'No se pudo eliminar el producto'];
             }
         } catch (PDOException $e) {
             // Manejar errores de la base de datos
             return ['status' => 'error', 'message' => 'Error en la base de datos: ' . $e->getMessage()];
         }
     }
 

    // Método para agregar un producto

    public function add($product)
    {
        try {
            // consulta SQL para incluir todos los campos necesarios
            $stmt = $this->conexion->prepare('
            INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, eliminado) 
            VALUES (:nombre, :marca, :modelo, :precio, :detalles, :unidades, :eliminado)
        ');

            // Vinculamos los parámetros con los valores del objeto $product
            $stmt->bindParam(':nombre', $product->nombre);
            $stmt->bindParam(':marca', $product->marca);
            $stmt->bindParam(':modelo', $product->modelo);
            $stmt->bindParam(':precio', $product->precio);
            $stmt->bindParam(':detalles', $product->detalles);
            $stmt->bindParam(':unidades', $product->unidades);
            $stmt->bindParam(':eliminado', $product->eliminado);  // Default 0 si no se especifica

            // Ejecutamos la consulta
            $stmt->execute();

            // Si todo fue bien, asignamos un mensaje de éxito
            $this->data = ['success' => 'Producto agregado correctamente'];
        } catch (PDOException $e) {
            // Si hubo algún error, asignamos el mensaje de error
            $this->data = ['error' => $e->getMessage()];
        }
    }

   
    //Metodo para editar productos
    public function edit($product)
    {
        try {
            $stmt = $this->conexion->prepare('UPDATE productos SET precio = :precio, detalles = :detalles, marca = :marca, modelo = :modelo, unidades = :unidades WHERE nombre = :nombre');

            // Vinculamos los parámetros con los valores del objeto $product
            $stmt->bindParam(':nombre', $product->nombre);
            $stmt->bindParam(':precio', $product->precio);
            $stmt->bindParam(':detalles', $product->detalles);  // Cambiado 'descripcion' por 'detalles'
            $stmt->bindParam(':marca', $product->marca);
            $stmt->bindParam(':modelo', $product->modelo);
            $stmt->bindParam(':unidades', $product->unidades);

            // Ejecutamos la consulta
            $stmt->execute();

            // Devolvemos la respuesta exitosa
            $this->data = ['success' => 'Producto editado correctamente'];
        } catch (PDOException $e) {
            // Si ocurre un error, devolvemos el mensaje de error
            $this->data = ['error' => $e->getMessage()];
        }
    }

    // Método para realizar la búsqueda de productos
    public function searchProducts($search)
    {
        // Prevenir inyecciones SQL usando consultas preparadas
        $sql = 'SELECT * FROM productos WHERE (id = :search OR nombre LIKE :search OR marca LIKE :search OR detalles LIKE :search) AND eliminado = 0';
        $stmt = $this->conexion->prepare($sql);

        // Preparar el parámetro de búsqueda
        $searchTerm = "%$search%";  // Asegurarse de que la búsqueda sea como un LIKE

        // Vincular el parámetro de búsqueda de forma segura
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener los resultados
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Devolver los resultados
        return $rows ? $rows : [];
    }

    // Método para obtener un producto por ID
    public function getProductById($id)
    {
        // Prevenir inyecciones SQL usando consultas preparadas
        $sql = 'SELECT * FROM productos WHERE id = :id AND eliminado = 0';  // Verificamos que el producto no esté eliminado
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);  // Vinculamos el parámetro ID de manera segura
        $stmt->execute();

        // Obtenemos el resultado
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si el producto existe, lo devolvemos, sino retornamos null
        return $product ? $product : null;
    }

    public function checkIfExists($nombre) {
        try {
            $stmt = $this->conexion->prepare("SELECT COUNT(*) AS total FROM productos WHERE nombre = :nombre");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->data = ['existe' => $result['total'] > 0];
        } catch (PDOException $e) {
            $this->data = ['error' => $e->getMessage()];
        }
    }
}
?>
