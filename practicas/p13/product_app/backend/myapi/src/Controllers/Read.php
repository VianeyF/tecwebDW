<?php

namespace Fvian\MyApi\Controllers;

use Fvian\MyApi\Database\DataBase;


class Read extends DataBase {
    
    // Método para obtener todos los productos.
    public function getAllProducts(): void {
        $query = "SELECT * FROM productos";
        $this->getData($query);  // Llama a getData para ejecutar la consulta.
    }
    
    // Método para buscar productos que coincidan con un nombre.
    public function searchProducts($name): void {
        $query = "SELECT * FROM productos WHERE nombre LIKE '%{$name}%'";
        $this->getData($query);
    }
    
    // Método para obtener un solo producto por nombre exacto.
    public function singleByName($name): void {
        $query = "SELECT * FROM productos WHERE nombre = '{$name}'";
        $this->getData($query);
    }
}
