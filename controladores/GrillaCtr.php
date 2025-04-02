<?php

class GrillaCtr
{
    private $controlador;
    private $grillaMdl;

    public function __construct(GrillaMdl $grillaMdl)
    {
        $this->grillaMdl = $grillaMdl;
        $this->cargarDatosGrilla($grillaMdl);

    }

    private function cargarDatosGrilla(GrillaMdl $grillaMdl)
    {
        $module = isset($_GET['module']) ? $_GET['module'] : '';

        switch ($module) {
            case 'usuarios':
                require_once 'controladores/UsuarioCtr.php';
                $this->controlador = UsuarioCtr::getInstance();
                break;
            case 'presupuestos':
                require_once 'controladores/PresupuestoCtr.php';
                $this->controlador = PresupuestoCtr::getInstance();
                break;
            case 'pedidos':
                require_once 'controladores/PedidoCompraCtr.php';
                $this->controlador = PedidoCompraCtr::getInstance();
                break;
            case 'productos':
                require_once 'controladores/ProductoCtr.php';
                $this->controlador = new ProductoCtr;
                break;
            case 'clientes':
                require_once 'controladores/ClienteCtr.php';
                $this->controlador = new ClienteCtr;
                break;
            case 'proveedores':
                require_once 'controladores/ProveedorCtr.php';
                $this->controlador = ProveedorCtr::getInstance();
                break;
            case 'reparaciones':
                require_once 'controladores/ReparacionCtr.php';
                $this->controlador = ReparacionCtr::getInstance();
                break;
            default:
                # code...
                break;
        }
    }

    public function mostrarGrilla()
    {
        $grillaMdl = $this->getGrillaMdl();
        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        require_once 'vistas/otros/grilla.php';
    }

    public function getGrillaMdl()
    {
        return $this->grillaMdl;
    }
}