<?php
namespace EJEMPLOS\PHP;

class Cabecera{
    private $titulo;
    private $ubicacion;

    public function__construct($title,$location){
        $this->titulo=$title;
        $this->ubicacion=$location;
    }
    public function__construct($title,$location){
       
    }
    public function graficar(){
        $estilo = 'font-size: 40px; text-align:'.this->ubicacion;
        echo '<div style="'.$estilo.'">';
        echo '<h4>'.$this->titulo.'</h4>';
        echo '</div>';
    }
}

<?php
namespace EJEMPLOS\PHP;

class Cabecera2{
    private $titulo;
    private $ubicacion;
    private $enlace;

    public function__construct($title,$location,$link){
        $this->titulo=$title;
        $this->ubicacion=$location;
        $this->enlace=$link;
    }
   
    public function graficar(){
        $estilo = 'font-size: 40px; text-align:'.this->ubicacion;
        echo '<div style="'.$estilo.'">';
        echo '<h4>';
        echo '<a href=".$this->enlace.'">.$this->titulo.'</a>';
        echo '</h4>';
        echo '</div>';
    }
}

?>

