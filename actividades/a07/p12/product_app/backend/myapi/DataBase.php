<?php
namespace MyApi;
use PDO;
use PDOException;

abstract class DataBase {
    // Propiedad protegida para la conexion a la base de datos
    protected $conexion;

    // Constructor que recibe los datos de conexión
    //'localhost','marketzone','root','vianey24'
    public function __construct($host, $dbname, $user, $password) {
        try {
            // Crear una nueva conexion PDO y asignarla a la propiedad protegida
        $this->conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
            // Configurar el modo de error de PDO para que lance excepciones
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            error_log("Conexión exitosa a la base de datos.");

        } catch (PDOException $e) {
            // Capturar cualquier error de conexión y mostrar un mensaje
            echo json_encode([
                'status' => 'error',
                'message' => 'Error de conexión: ' . $e->getMessage()
            ]);
            exit();
        }
    }
}
?>
