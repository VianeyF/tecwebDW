<?php
namespace Gonza\P13\Read;
use Gonza\P13\myapi\DataBase as DataBase;

class Read extends DataBase {
    public function __construct(string $db) {
        parent::__construct('root', '1001', $db);
    }

    public function list() {
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        if ( $result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0") ) {
            // SE OBTIENEN LOS RESULTADOS
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            if(!is_null($rows)) {
                // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                foreach($rows as $num => $row) {
                    foreach($row as $key => $value) {
                        $this->data[$num][$key] = $value;
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
    }

    public function search($search) {
        // SE VERIFICA HABER RECIBIDO EL ID
        if( isset($search) ) {
            // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
            $sql = "SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
            if ( $result = $this->conexion->query($sql) ) {
                // SE OBTIENEN LOS RESULTADOS
                $rows = $result->fetch_all(MYSQLI_ASSOC);

                if(!is_null($rows)) {
                    // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                    foreach($rows as $num => $row) {
                        foreach($row as $key => $value) {
                            $this->data[$num][$key] = $value;
                        }
                    }
                }
                $result->free();
            } else {
                die('Query Error: '.mysqli_error($this->conexion));
            }
            $this->conexion->close();
        }
    }

    public function single($id) {
        // Prepara la consulta SQL para evitar inyecciones SQL
        $query = "SELECT * FROM productos WHERE id = ?";

        if ($stmt = mysqli_prepare($this->conexion, $query)) {
            // Asocia el parámetro y ejecuta la consulta
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            // Obtiene el resultado de la consulta
            $result = mysqli_stmt_get_result($stmt);

            // Verifica si se obtuvo un producto
            if ($row = mysqli_fetch_assoc($result)) {
                $this->data = array(
                    'nombre' => $row['nombre'],
                    'precio' => $row['precio'],
                    'unidades' => $row['unidades'],
                    'modelo' => $row['modelo'],
                    'marca' => $row['marca'],
                    'detalles' => $row['detalles'],
                    'imagen' => $row['imagen'],
                    'id' => $row['id']
                );
            } else {
                $this->data = ['error' => 'Producto no encontrado'];
            }

            // Cierra el statement
            mysqli_stmt_close($stmt);
        } else {
            $this->data = ['error' => 'Error al preparar la consulta'];
        }
    }
    // Método para obtener un producto específico usando su nombre
    public function singleByName($nombre) {
 
        if (empty($nombre)) {
            $this->data = ['error' => 'Nombre no proporcionado'];
            return;
        }
    
        if ($this->conexion) {
            // Usamos una consulta preparada para evitar inyección de SQL
            $stmt = $this->conexion->prepare("SELECT COUNT(*) FROM productos WHERE nombre = ?");
            $stmt->bind_param("s", $nombre);
            $stmt->execute();
            $stmt->bind_result($exists);
            $stmt->fetch();
            $stmt->close();
    
            // Asignamos el resultado al atributo `data` del objeto
            $this->data = ['exists' => (bool)$exists];
        } else {
            $this->data = ['error' => 'No se pudo conectar a la base de datos'];
        }
    }
}
?>