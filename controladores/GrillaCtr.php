<?php
require_once 'controladores/UsuarioCtr.php';
class GrillaCtr{
    private $controlador;
    private $grillaMdl;

    public function __construct(GrillaMdl $grillaMdl) {
        $this->grillaMdl = $grillaMdl;
        $this->cargarDatosGrilla($grillaMdl);
    }

    private function cargarDatosGrilla(GrillaMdl $grillaMdl){
        $module = isset($_GET['module'])?$_GET['module']:'';
        
        switch ($module) {
            case 'usuarios':
                $this->controlador = new UsuarioCtr;
                break;
            
            default:
                # code...
                break;
        }
    }

    public function mostrarGrilla(){
        require_once 'vistas/otros/grilla.php';
    }

    public function getGrillaMdl(){
        return $this->grillaMdl;
    }
}
?>