<?php
namespace Gonza\P13\Create;
use Gonza\P13\myapi\DataBase as DataBase;

class Create extends DataBase {
    public function __construct(string $db) {
        parent::__construct('root', '1001', $db);
    }
    
    public function add($producto) {
        $data = array(); 
    
        if(!empty($producto)) {
            $jsonOBJ = json_decode($producto);
    
            $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
            $result = $this->conexion->query($sql);
    
            if ($result->num_rows == 0) {
                $this->conexion->set_charset("utf8");
                $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
                if ($this->conexion->query($sql)) {
                    $this->data = [
                        'status' => 'success',
                        'message' => 'Producto agregado correctamente'
                    ];
                } else {
                    $this->data = [
                        'status' => 'success',
                        'message' => "ERROR: No se ejecutó $sql. " . mysqli_error($this->conexion)
                    ];
                    }
            } else {
                $this->data = [
                    'status' => 'error',
                    'message' => 'Producto existente'
                ];
            }
    
            $result->free();
            $this->conexion->close();
        } 
    }
    
}
?>