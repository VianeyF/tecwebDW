<?php

namespace Fvian\MyApi\Controllers;

use Fvian\MyApi\Database\DataBase;

class Update extends DataBase
{
    // Método para editar un producto.
    public function edit($product): void
    {
        $query = "
            UPDATE productos 
            SET precio = '{$product->precio}', detalles = '{$product->detalles}', marca = '{$product->marca}', modelo = '{$product->modelo}', unidades = '{$product->unidades}' 
            WHERE nombre = '{$product->nombre}'
        ";
        
        $this->getData($query);  // Ejecuta la consulta de actualización.
    }
}
