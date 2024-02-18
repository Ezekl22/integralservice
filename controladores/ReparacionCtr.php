<?php
require_once 'controladores/PresupuestoCtr.php';
// require_once 'models/PresupuestoDAO.php';
// require_once 'models/ProductoPresupuestoMdl.php';
// require_once 'controladores/ClienteCtr.php';
// require_once 'controladores/ProductoCtr.php';

class ReparacionCtr
{
    private $presupuestoCtr;

    public function __construct()
    {
        $this->presupuestoCtr = new PresupuestoCtr();
        // $this->presupuestoDAO = new PresupuestoDAO();
        // $this->clienteCtr = new ClienteCtr();
        // $this->productoCtr = new ProductoCtr();
        // $action = isset($_GET['action'])?$_GET['action']:'';
        // $id = isset($_GET['id'])?$_GET['id']:'';
        // switch ($action) {
        //     case 'created':
        //         $this->create();
        //         break;
        //     case 'canceled':
        //         $this->canceled($id);
        //         break;
        //     case 'edited':
        //         $this->update($id);
        //         break;
        //     case 'facturar':
        //         $this->facturar($id);
        //         break;
        // }
    }

    public function index()
    {
        //     // Obtener la lista de usuarios desde el modelo
        //     $presupuestos = $this->presupuestoDAO->getAllPresupuestos();
        //     $action = isset($_GET['action']) ? $_GET['action'] : '';
        //     $presupuestoCtr = $this;
        //     if ($action == 'see'){
        //         $id = isset($_GET['id']) ? $_GET['id'] : '';
        //         $presupuesto = $this->getPresupuestoById($id);
        //         $cliente = $this->getClienteById($presupuesto->getIdCliente());
        //         $nombreCliente = $cliente['nombre'].' '.$cliente['apellido'];
        //         $productosPre = $this->getProductosPresupuestoById($presupuesto->getIdPresupuesto());
        //         $total = 0;
        //     }

        //     for ($i=0; $i < count($presupuestos); $i++) { 
        //         $presupuestos[$i][1] = $this->getNombreClienteById($presupuestos[$i][1]);
        //     }

        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        $grillaMdl = new GrillaMdl(GRILLA_PRESUPUESTOS, $this->presupuestoCtr->getAllReparaciones(), [0, 1]);
        $grillaCtr = new GrillaCtr($grillaMdl);

        require_once 'vistas/reparaciones/index.php';
    }

    // public function getPantallaCreate(){
    //     session_start();
    //     $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
    //     session_write_close();
    //     require_once 'vistas/presupuestos/create.php';
    // }

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

