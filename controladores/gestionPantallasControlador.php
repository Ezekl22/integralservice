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
    }

    public function cargarPantalla(){
        $tipoUsuario = "";
        //verifico si hay un parametro get de module, si lo hay, traigo el tipo de usuario
        if ($this->module && !empty($this->module)) {
            $sesionCtr = $_SESSION['session'];
            $tipoUsuario = $sesionCtr->getUsuarioSesionado()->getTipo();
        }
        switch ( $this->module) {
            case 'presupuestos':
                // verifico que el tipo de usuario no tiene acceso al modulo y si no lo tiene lo redirijo al menu
                if ( strtoupper($tipoUsuario) != "REPARADOR") {
                    include_once('./controladores/PresupuestoCtr.php');
                    $indexPage = new PresupuestoCtr();
                }else{
                    $this->redireccionar('menu');
                }
                break;
            case 'reparacion':
                // verifico que el tipo de usuario no tiene acceso al modulo y si no lo tiene lo redirijo al menu
                if ( strtoupper($tipoUsuario)!= "VENDEDOR") {
                    include_once('controladores/ReparacionControlador.php');
                }else{
                    $this->redireccionar('menu');
                }
                break;
            case 'clientes':
                // verifico que el tipo de usuario no tiene acceso al modulo y si no lo tiene lo redirijo al menu
                if ( strtoupper($tipoUsuario) != "REPARADOR")  {
                    include_once('controladores/ClienteControlador.php');
                    $indexPage = new ClienteCtr();
                }else{
                    $this->redireccionar('menu');
                }
                break;
            case 'proveedores':
                // verifico que el tipo de usuario no tiene acceso al modulo y si no lo tiene lo redirijo al menu
                if ( strtoupper($tipoUsuario) == "ADMINISTRADOR" || strtoupper($tipoUsuario) == "ADMINISTRADOR BASE")  {
                    include_once('controladores/ProveedorCtr.php');
                    $indexPage = new ProveedorCtr();
                }else{
                    $this->redireccionar('menu');
                }
                break;
          case 'pedidos':
                // verifico que el tipo de usuario no tiene acceso al modulo y si no lo tiene lo redirijo al menu
                if ( strtoupper($tipoUsuario) != "REPARADOR") {
                    include_once('controladores/PedidoCompraControlador.php');
                }else{
                    $this->redireccionar('menu');
                }
                break;
            case 'usuarios':
                // verifico que el tipo de usuario no tiene acceso al modulo y si no lo tiene lo redirijo al menu
                if ( strtoupper($tipoUsuario) == "ADMINISTRADOR" || strtoupper($tipoUsuario) == "ADMINISTRADOR BASE")  {
                    include_once './controladores/UsuarioCtr.php';
                    $indexPage = new UsuarioCtr();
                }else{
                    $this->redireccionar('menu');
                }
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
            if ($this->action) {
                if ($this->action == 'login') {
                    $sesionCtr = new SesionCtr();
                    $sesionCtr->verificarInicioSesion();
                }else if($this->action == 'logout'){
                    $sesionCtr = $_SESSION['session'];
                    $sesionCtr->cerrarSesion($this);
                }
            }
                
        }
    }

    public function redireccionar($modulo){
        ob_start();
        header("Location: index.php?".($modulo && $modulo != "" ?"module=$modulo":""));
        ob_end_flush();
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