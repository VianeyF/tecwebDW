<?php

namespace Fvian\MyApi\Controllers;

use Fvian\MyApi\Database\DataBase;

class Create extends DataBase{

    // Método para agregar un producto.
    public function add($product): void
    {
        $query = "
            INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, eliminado) 
            VALUES ('{$product->nombre}', '{$product->marca}', '{$product->modelo}', '{$product->precio}', '{$product->detalles}', '{$product->unidades}', '{$product->eliminado}')
        ";
        
        $this->getData($query);  // Ejecuta la consulta de inserción.
    }
}
