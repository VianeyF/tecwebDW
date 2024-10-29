<?php
class Persona{
    private $nombre:


    public function  inicilaizar ($name){
        $this->nombre = $name;
    }

    public function mostrar(){
        echo '<p>',this->nombre.'<p>';
    }
}
?>