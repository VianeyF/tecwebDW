<?php
class Menu {
    private $opciones = NULL;
    Private $direccion;
}

puclic function __construct($dir){
    $this->opciones = array();
    $this->direccion = $dir;
}

public function insertar_opcion ($op){
    $this->opciones[]= $op;
}

public function graficar_horizontal(){
    for($i=0; $i<count($this->opciones); $i++){
        $this->opciones[$i]->graficar();
        echo ' - ';
    }
}

public function graficar_vertical(){
    for($i=0; $i<count($this->opciones); $i++){
        $this->opciones[$i]->graficar();
        echo ' <br>';
    }
}
//=== exactamente igual
public function graficar(){
    if ($this->direccion === 'horizontal'){
        $this->graficar_horizontal();
    }
    else{
        if ($this->direccion === 'vertical'){
        $this->graficar_vertical();
    }
}


?>