<?php

namespace Fvian\MyApi\Database;

use PDO;
use PDOException;

abstract class DataBase {
    protected $conexion;  // Almacena la conexión a la base de datos.
    protected $data = [];   // Almacena los resultados de una consulta en la base de datos.

    // Constructor que establece la conexión a la base de datos usando PDO.
    public function __construct($dbName) {
        $this->conexion = new \PDO("mysql:host=localhost;dbname={$dbName}", 'root', 'vianey24');
        $this->conexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    // Método para ejecutar una consulta y almacenar los resultados en $data.
    public function getData($query) {
        try {
            $stmt = $this->conexion->prepare($query);
            $stmt->execute();
            $this->data = $stmt->fetchAll(\PDO::FETCH_ASSOC);  // Guarda el resultado en el array $data.
            return $this->data;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
