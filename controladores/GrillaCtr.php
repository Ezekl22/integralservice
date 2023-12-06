<?php
class GrillaCtr{
    private $datosCabecera;
    private $datosCuerpo;

    public function __construct() {
        $this->cargarDatosGrilla();
    }

    private function cargarDatosGrilla(){
        require_once './assets/constantes.php';
        
        $module = isset($_GET['module'])?$_GET['module']:'';
        
        switch ($module) {
            case 'usuarios':
                require_once 'UsuarioControlador.php';
                $usuarioCtr = new UserController;
                $this->datosCabecera = $GrillaUsuariosIndex;
                $this->datosCuerpo = $usuarioCtr->getAllUsers();
                break;
            
            default:
                # code...
                break;
        }
    }

    public function getDatosCabecera(){
        return $this->datosCabecera;
    }

    public function getDatosCuerpo(){
        return $this->datosCuerpo;
    }
}
?>