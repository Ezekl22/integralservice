<?php
require_once 'models/PresupuestoMdl.php';
require_once 'models/PresupuestoDAO.php';
require_once 'controladores/ClienteControlador.php';
require_once 'controladores/ProductoCtr.php';

class PresupuestoCtr {
    private $presupuestoDAO;
    private $clienteCtr;
    private $productoCtr;

    public function __construct() {
        $this->presupuestoDAO = new PresupuestoDAO();
        $this->clienteCtr = new ClienteCtr();
        $this->productoCtr = new ProductoCtr();
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

    // public function create() {
    //     // Mostrar el formulario de creación de usuario
    //     require_once 'vistas/presupuestos/create.php';
    // }

    // public function store($data) {
    //     // Validar los datos del formulario
    //     // ...

    //     // Crear un nuevo usuario en la base de datos
    //     $presupuesto = new PresupuestoMdl($data['idcliente'], $data['nrocomprobante'], $data['tipo'], $data['estado'], $data['fecha'], $data['puntoventa'], $data['total']);
    //     $this->presupuestoDAO->createPresupuesto($presupuesto);

    //     // Redireccionar a la página principal de usuarios
    //     header('Location: index.php?action=index');
    // }

    public function getPantallaEdit() {
        
        require_once 'vistas/presupuestos/edit.php';
        $this->index();
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

    public function getProductosById($ids){
        return $this->productoCtr->getProductosById($ids);
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

    public function getPresupuestoById($id){
        return $this->presupuestoDAO->getPresupuestoById($id);
    }

    // public function getPantallaDelete(){
    //     require_once 'vistas/usuario/delete.php';
    //     $this->index();
    // }

    // public function delete($id) {
    //     // Eliminar el usuario de la base de datos
    //     $this->presupuestoDAO->deletePresupuesto($id);

    //     // Redireccionar a la página principal de usuarios
    //     header('Location: index.php?action=index');
    // }

    public function getAllClientes(){
        return $this->clienteCtr->getAllClientes();
    }

    public function getAllProductos(){
        return $this->productoCtr->getAllProductos();
    }
}
