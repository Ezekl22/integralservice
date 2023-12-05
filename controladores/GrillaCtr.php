<?php
include 'assets/constantes.php';
class GrillaCtr{
    private $datosCabecera;

    public function __construct() {
        //$this->clientDAO = new ClientDAO();
        // $action = isset($_GET['action'])?$_GET['action']:'';
        // $module = isset($_GET['module'])?$_GET['module']:'';
        // $id = isset($_GET['id'])?$_GET['id']:'';
        // if($module == 'clientes'){
        //     switch ($action) {
        //         case 'created':
        //             $this->create();
        //             break;
        //         case 'deleted':
        //             $this->delete($id);
        //             break;
        //         case 'edited':
        //             $this->update($id);
        //             break;
        //     }
        // }
    }

    private function getDatosCabecera(){
        $module = isset($_GET['module'])?$_GET['module']:'';
        
        switch ($module) {
            case 'usuarios':
                $this->datosCabecera = $GrillaUsuariosIndex;
                break;
            
            default:
                # code...
                break;
        }
    }
}
?>