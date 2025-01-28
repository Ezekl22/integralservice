<?php
require_once 'controladores/PresupuestoCtr.php';
require_once 'models/ReparacionDAO.php';
// require_once 'models/ProductoPresupuestoMdl.php';
// require_once 'controladores/ClienteCtr.php';
// require_once 'controladores/ProductoCtr.php';

class ReparacionCtr
{
    private $reparacionDAO;
    private $presupuestoCtr;
    private static $instance = null;

    public function __construct()
    {
        $this->reparacionDAO = new ReparacionDAO();
        $this->presupuestoCtr = new PresupuestoCtr();
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        switch ($action) {
            case 'created':
                $this->reparar();
                break;
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ReparacionCtr();
        }
        return self::$instance;
    }

    public function index()
    {
        $reparaciones = $this->getAllReparaciones();
        for ($i = 0; $i < count($reparaciones); $i++) {
            $reparaciones[$i][1] = $this->presupuestoCtr->getNombreClienteById($reparaciones[$i][1]);
        }

        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        $grillaMdl = new GrillaMdl(GRILLA_PRESUPUESTOS, $reparaciones, [0, 1]);
        $grillaCtr = new GrillaCtr($grillaMdl);

        require_once 'vistas/reparaciones/reparacion.php';
    }

    public function getAllReparaciones()
    {
        return $this->reparacionDAO->getAllReparaciones();
    }

    public function reparar()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $this->reparacionDAO->reparar($id);
    }

    // public function create() {
    //     if (isset($_POST['idcliente'])) {
    //         $productos = [] ;
    //         $precioTotal = 0;
    //         $estado = isset($_POST['tipo'])? $_POST['tipo'] == 'Venta'? 'Presupuestado': 'Pendiente presupuesto' :'';
    //         foreach ($_POST['idproductos'] as $index => $idproducto) {
    //             $precioUnit = $this->productoCtr->getProductoById($idproducto)['precioventa'];
    //             $cantidad = intval($_POST['cantidad'][$index]);
    //             $producto = new ProductoPresupuestoMdl($idproducto, $precioUnit, $cantidad);
    //             $precioTotal += $precioUnit * $cantidad;
    //             array_push($productos, $producto);
    //         }
    //         $presupuesto = new PresupuestoMdl($_POST['idcliente'], $productos, $this->getNuevoNroComprobante(), 
    //                                           $_POST['tipo'], $estado, '0001', $precioTotal);

    //         $this->presupuestoDAO->create($presupuesto);
    //     }
    // }

    // public function getPantallaEdit() {
    //     $this->index();
    //     require_once 'vistas/presupuestos/edit.php';
    // }

    // public function getNuevoNroComprobante() {
    //     $auxNroComprobante = strval($this->presupuestoDAO->getNuevoNroComprobante() + 1);
    //     $nroComprobante = str_pad($auxNroComprobante, 10, 0, STR_PAD_LEFT);
    //     return $nroComprobante;
    // }

    // public function getNombreClienteById($id){
    //     $cliente = $this->clienteCtr->getClienteById($id);
    //     return $cliente['nombre'].' '.$cliente['apellido'];
    // }

    // public function getClienteById($id){
    //     $cliente = $this->clienteCtr->getClienteById($id);
    //     return $cliente;
    // }

    // public function getProductoById($id){
    //     $producto = $this->productoCtr->getProductoById($id);
    //     return $producto;
    // }

    // public function getProductosPresupuestoById($id) {
    //     return $this->presupuestoDAO->getProductosPresupuestoById($id);
    // }

    // public function update($id) {

    //     if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //         if(isset($_POST["idcliente"])){
    //             $presupuesto = new PresupuestoMdl($_POST["idcliente"], $_POST["nrocomprobante"], $_POST['tipo'], $_POST["estado"], $_POST["fecha"], $_POST["puntoventa"], $_POST["total"]);
    //             $presupuesto->setIdPresupuesto($id);
    //             $this->presupuestoDAO->updatePresupuesto($presupuesto);
    //         }
    //     }
    // }

    // public function getPresupuestoById($id){
    //     $presupuestoBD = $this->presupuestoDAO->getPresupuestoById($id);
    //     $productosPresupuestoBD = $this->presupuestoDAO->getProductosPresupuestoById($id);
    //     $presupuesto = NEW PresupuestoMdl($presupuestoBD['idcliente'], $productosPresupuestoBD, $presupuestoBD['nrocomprobante'], $presupuestoBD['tipo'], $presupuestoBD['estado'], $presupuestoBD['puntoventa'], $presupuestoBD['total']);
    //     $presupuesto->setIdPresupuesto($id);
    //     $presupuesto->setFecha($presupuestoBD['fecha']);
    //     return  $presupuesto;
    // }

    // public function getPantallaDelete(){
    //     require_once 'vistas/presupuestos/delete.php';
    //     $this->index();
    // }

    // public function canceled($id){
    //     $presupuesto = $this->getPresupuestoById($id);
    //     $estado = $presupuesto->getEstado();
    //     if($estado != 'Pendiente presupuesto' || $estado != 'En reparacion' || $estado != '')
    //         $this->presupuestoDAO->cancel($id);
    // }

    // public function getAllClientes(){
    //     return $this->clienteCtr->getAllClientes();
    // }

    // public function getAllProductos(){
    //     return $this->productoCtr->getAllProductos();
    // }

    // public function facturar($id){
    //     $presupuesto = $this->getPresupuestoById($id);
    //     $estado = $presupuesto->getEstado();
    //     if($estado != 'Pendiente presupuesto' && $estado != 'En reparacion' && $estado != '' && $estado != 'Facturado'){
    //         $presupuesto->setEstado('Facturado');
    //         $presupuesto->setNroComprobante('C-'.$presupuesto->getNroComprobante().'-0001');
    //         $this->presupuestoDAO->updatePresupuesto($presupuesto);
    //     }
    // }
}

