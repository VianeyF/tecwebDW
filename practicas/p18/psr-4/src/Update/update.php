<?php

namespace Gonza\P13\Update;
use Gonza\P13\myapi\DataBase as DataBase;

class Update extends DataBase {
    public function __construct(string $db) {
        parent::__construct('root', '1001', $db);
    }

    public function edit($object) {
        // Verifica si el objeto no está vacío
        if (!empty($object)) {
            // Se transforma el string del JSON a objeto
            $jsonOBJ = json_decode($object);

            // Asegúrate de que el ID del producto esté presente
            if (isset($jsonOBJ->id)) {
                $id = $jsonOBJ->id;

                // Se asume que los datos ya fueron validados antes de enviarse
                $sql = "UPDATE productos SET 
                            nombre = '{$jsonOBJ->nombre}', 
                            marca = '{$jsonOBJ->marca}', 
                            modelo = '{$jsonOBJ->modelo}', 
                            precio = {$jsonOBJ->precio}, 
                            detalles = '{$jsonOBJ->detalles}', 
                            unidades = {$jsonOBJ->unidades}, 
                            imagen = '{$jsonOBJ->imagen}' 
                        WHERE id = $id AND eliminado = 0";

                // Ejecuta la consulta
                if ($this->conexion->query($sql) === TRUE) {
                    $this->data = [
                        'status' => 'success',
                        'message' => 'Producto actualizado correctamente'
                    ];
                } else {
                    $this->data = [
                        'message' => 'ERROR: No se ejecutó la consulta. ' . $this->conexion->error
                    ];
                }
            } else {
                $this->data = ['message' => 'ERROR: ID de producto no proporcionado.'];
            }
        } else {
            $this->data = ['message' => 'ERROR: El objeto de producto está vacío.'];
        }
    }
}