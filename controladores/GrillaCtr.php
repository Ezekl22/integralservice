<?php

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
                require_once 'controladores/UsuarioCtr.php';
                $this->controlador = new UsuarioCtr;
                break;
            case 'presupuestos':
                require_once 'controladores/PresupuestoCtr.php';
                $this->controlador = new PresupuestoCtr;
                break;
            
            default:
                # code...
                break;
        }
    }

    public function mostrarGrilla(){
        $grillaMdl = $this->getGrillaMdl();
        require_once 'vistas/otros/grilla.php';
    }

    public function getGrillaMdl(){
        return $this->grillaMdl;
    }
}
?>