<?php
namespace EJEMPLOS\PHP;

class Cabecera{
    private $titulo;
    private $ubicacion;
    private $colorFuente;
    private $colorFondo;

    public function__construct($title,$location='center',$cfont='FFFFFF',$cback='#000000'){
        $this->titulo=$title;
        $this->ubicacion=$location;
        $this->colorFuente=$cfont;
        $this->colorFondo=$cback;

    }

    public function graficar(){
        $estilo = 'font-size: 30px; text-align:'.this->ubicacion;
        $estilo.= '; color:'.$this->colorFuente;
        $estilo.= '; background-color:'.$this->colorFondo.';';
        echo '<div style="'.$estilo.'">';
        echo '<h4>'.$this->titulo.'</h4>';
        echo '</div>';
    }
}

?>

