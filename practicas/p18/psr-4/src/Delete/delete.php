<?php

namespace Gonza\P13\Delete;
use Gonza\P13\myapi\DataBase as DataBase;


class Delete extends DataBase {
    public function __construct(string $db) {
        parent::__construct('root', '1001', $db);
    }

    public function delet($id) {
        // Definir la consulta SQL para marcar el producto como eliminado
        $sql = "UPDATE productos SET eliminado = 1 WHERE id = ?";
        
        // Preparar la consulta para evitar inyecciones SQL
        $stmt = $this->conexion->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            
            // Ejecutar la consulta y verificar si fue exitosa
            if ($stmt->execute()) {
                $this->data = [
                    'status' => 'success',
                    'message' => 'Producto eliminado con éxito'
                ];
            } else {
                $this->data = [
                    'status' => 'error',
                    'message' => "ERROR: No se ejecutó la consulta. " . $this->conexion->error
                ];
            }
            
            // Cerrar el statement
            $stmt->close();
        } 
    }
}