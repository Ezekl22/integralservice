<?php
require_once 'models/PresupuestoMdl.php';
require_once 'models/PresupuestoDAO.php';
require_once 'models/ProductoPresupuestoMdl.php';
require_once 'controladores/ClienteCtr.php';
require_once 'controladores/ProductoCtr.php';

class PresupuestoCtr {
    private $presupuestoDAO;
    private $clienteCtr;
    private $productoCtr;

    public function __construct() {
        $this->presupuestoDAO = new PresupuestoDAO();
        $this->clienteCtr = new ClienteCtr();
        $this->productoCtr = new ProductoCtr();
        $action = isset($_GET['action'])?$_GET['action']:'';
        $id = isset($_GET['id'])?$_GET['id']:'';
        switch ($action) {
            case 'created':
                $this->create();
                break;
            case 'canceled':
                $this->canceled($id);
                break;
            case 'edited':
                $this->update($id);
                break;
        }
    }

    public function index() {
        // Obtener la lista de usuarios desde el modelo
        $presupuestos = $this->presupuestoDAO->getAllPresupuestos();

        // Cargar la vista con los datos
        require_once 'vistas/presupuestos/index.php';
    }

    public function getPantallaCreate(){
        require_once 'vistas/presupuestos/create.php';
    }

    public function create() {
        // Verifica si se han enviado datos por POST
        
        if (isset($_POST['idcliente'])) {
            $productos = [] ;
            $precioTotal = 0;
            foreach ($_POST['idproductos'] as $index => $idproducto) {
                $precioUnit = $this->productoCtr->getProductoById($idproducto)['precioventa'];
                $cantidad = intval($_POST['cantidad'][$index]);
                $producto = new ProductoPresupuestoMdl($idproducto, $precioUnit, $cantidad);
                $precioTotal += $precioUnit * $cantidad;
                array_push($productos, $producto);
            }
            $presupuesto = new PresupuestoMdl($_POST['idcliente'], $productos, $this->getNuevoNroComprobante(), 
                                              $_POST['tipo'], "Presupuestado", '0001', $precioTotal);
    
            $this->presupuestoDAO->create($presupuesto);
        }
    }

    public function getPantallaEdit() {
        $this->index();
        require_once 'vistas/presupuestos/edit.php';
    }

    public function getNuevoNroComprobante() {
        $auxNroComprobante = strval($this->presupuestoDAO->getNuevoNroComprobante() + 1);
        $nroComprobante = str_pad($auxNroComprobante, 10, 0, STR_PAD_LEFT);
        return $nroComprobante;
    }

    public function getNombreClienteById($id){
        $cliente = $this->clienteCtr->getClienteById($id);
        return $cliente['nombre'].' '.$cliente['apellido'];
    }

    public function getClienteById($id){
        $cliente = $this->clienteCtr->getClienteById($id);
        return $cliente;
    }

    public function getProductoById($id){
        $cliente = $this->productoCtr->getProductoById($id);
        return $cliente;
    }

    public function getProductosPresupuestoById($id) {
        return $this->presupuestoDAO->getProductosPresupuestoById($id);
    }

    public function update($id) {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST["idcliente"])){
                $presupuesto = new PresupuestoMdl($_POST["idcliente"], $_POST["nrocomprobante"], $_POST['tipo'], $_POST["estado"], $_POST["fecha"], $_POST["puntoventa"], $_POST["total"]);
                $presupuesto->setIdPresupuesto($id);
                $this->presupuestoDAO->updatePresupuesto($presupuesto);
            }
        }
    }

    public function getProductosPresupuesto($id) {

    }

    public function getPresupuestoById($id){
        return $this->presupuestoDAO->getPresupuestoById($id);
    }

    public function getPantallaDelete(){
        require_once 'vistas/presupuestos/delete.php';
        $this->index();
    }

    public function canceled($id){
        $estado = $this->presupuestoDAO->getEstado($id);
        if($estado != 'Pendiente presupuesto' || $estado != 'En reparacion' || $estado != '')
        $this->presupuestoDAO->cancel($id);
    }

    public function getAllClientes(){
        return $this->clienteCtr->getAllClientes();
    }

    public function getAllProductos(){
        return $this->productoCtr->getAllProductos();
    }
}
