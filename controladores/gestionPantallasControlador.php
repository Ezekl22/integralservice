<?php
require_once 'models/GestionPantallasMdl.php';
require_once 'models/GestionPantallasDAO.php';
require_once 'models/PopUpMdl.php';
require_once 'controladores/SesionCtr.php';

class GestionPantallasControlador {
    //private $GestionPantallasDAO;
    private $action;
    private $module; 

    public function __construct() {
        $this->module = isset($_GET['module']) ? $_GET['module'] : ''; 
        $this->action = isset($_GET['action']) ? $_GET['action'] : '';
        //$this->cargarPantalla();
        //$id = isset($_GET['id']) ? $_GET['id'] : '';
        //$this->GestionPantallasDAO = new GestionPantallasDAO();
    }

    public function cargarPantalla(){
        switch ( $this->module) {
            case 'presupuestos':
                include_once('./controladores/PresupuestoCtr.php');
                $indexPage = new PresupuestoCtr();
                break;
            case 'reparacion':
                include_once('controladores/ReparacionControlador.php');
                break;
            case 'clientes':
                include_once('controladores/ClienteControlador.php');
                $indexPage = new ClienteCtr();
                break;
            case 'proveedores':
                include_once('controladores/ProveedorCtr.php');
                $indexPage = new ProveedorCtr();
                break;
          case 'pedidos':
                include_once('controladores/PedidoCompraControlador.php');
                break;
            case 'usuarios':
                include_once './controladores/UsuarioCtr.php';
                $indexPage = new UsuarioCtr();
                break;
            case 'menu':
                include_once './controladores/MenuControlador.php';
                $indexPage = new MenuController();
                break;
            default:
                include_once './vistas/inicio/index.php';
                break;
        }

        if($this->module){
            switch ($this->action) {
                case 'edit':
                        $indexPage ->getPantallaEdit();
                        break;
                case 'delete':
                        $indexPage ->getPantallaDelete();
                        break;
                case 'create':
                        $indexPage ->getPantallaCreate();
                        break;
                default:
                        $indexPage -> index();
                        break;
            }
        }else{
            if ($this->action && $this->action == 'login') {
                $sesionCtr = new SesionCtr();
                $sesionCtr->verificarInicioSesion();
            }
                
        }
    }

    public function crearPopUp(PopUpMdl $popUpMdl){
        $popUpM = $popUpMdl;
        include 'vistas/otros/popUp.php';
    }

    public function getModule(){
        return $this->module;
    }

    public function getAction(){
        return $this->action;
    }

    // public function getGestionPantallasDAO() {
    //     // Obtener la lista de usuarios desde el modelo
    //     return $this->GestionPantallasDAO;
    // }

    // public function mostrarOcultarPantallaEditar(int $id) {
    //     $gPantallas = $this->GestionPantallasDAO->getGestionPantallasById($id);
    //     $inUse = $gPantallas['inuse'] == 1? 0 : 1;
    //     $gestionPantallas = new GestionPantallasMdl($gPantallas['name'],$gPantallas['action'], $inUse, $id);
    //     $this->GestionPantallasDAO->updateGestionPantallas($gestionPantallas);
    // }

    // public function getGestionPantallasById($id) {
    //     $gPResult = $this->GestionPantallasDAO->getGestionPantallasById($id);
    //     $gPantallas = new GestionPantallasMdl($gPResult['name'],$gPResult['action'],$gPResult['inuse'],$id);
    //     return $gPantallas;
    // }
}