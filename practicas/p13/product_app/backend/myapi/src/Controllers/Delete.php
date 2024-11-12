<?php

namespace Fvian\MyApi\Controllers;

use Fvian\MyApi\Database\DataBase;

class Delete extends DataBase {
    
    // Método para eliminar un registro usando el ID.
    public function delete($id): void {
        $query = "DELETE FROM productos WHERE id = '{$id}'";
        $this->getData($query);  // Ejecuta la consulta de eliminación.
    }
}
