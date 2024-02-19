<?php
require_once 'models/ClienteMdl.php';
require_once 'models/ClienteDAO.php';
require_once 'controladores/GrillaCtr.php';
require_once 'models/GrillaMdl.php';

class ClienteCtr{
    private $clienteDAO;

    public function __construct() {
        $this->clienteDAO = new ClienteDAO();
        $action = isset($_GET['action'])?$_GET['action']:'';
        $module = isset($_GET['module'])?$_GET['module']:'';
        $id = isset($_GET['id'])?$_GET['id']:'';
        if($module == 'clientes'){
            switch ($action) {
                case 'created':
                    $this->create();
                    break;
                case 'deleted':
                    $this->delete($id);
                    break;
                case 'edited':
                    $this->update($id);
                    break;
                case 'searched':
                    $this->search();
                    break;
            }
        }
    }

    public function index()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $termino = isset($_POST['termino']) ? $_POST['termino'] : "";
        session_start();
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        session_write_close();
        $grillaMdl = new GrillaMdl(GRILLA_CLIENTES, $action == 'searched' && $termino != "" ? $this->search() : $this->getAllClientes(), [0, 1]);
        $grillaCtr = new GrillaCtr($grillaMdl);

        // Cargar la vista con los datos
        require_once 'vistas/cliente/cliente.php';
    }

    public function getPantallaCreate()
    {
        $this->index();
        require_once 'vistas/cliente/create.php';
    }

    public function create() {
        $cliente = new Cliente($_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['cuit'], $_POST['iva']);
        $this->clienteDAO->createCliente($cliente);
    }

    public function getPantallaEdit()
    {
        $this->index();
        require_once 'vistas/cliente/edit.php';
    }

    public function update($id) {
        if(isset($_POST["nombre"])){
            $cliente = new Cliente($_POST["nombre"], $_POST["apellido"], $_POST["email"], $_POST["cuit"], $_POST["categoriafiscal"]);
            $cliente->setId($id);
            $this->clienteDAO->update($cliente);
        }
    }
    
    public function delete($id) {
        $this->clienteDAO->delete($id);
    }

    public function getAllClientes(){
        return $this->clienteDAO->getAllClientes();
    }

    public function getPantallaDelete(){
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        $gestionPantallaCtr->crearPopUp(new PopUpMdl('delete','Eliminar Cliente',"",BOTONES_POPUP_ELIMINAR,'index.php?action=delete'));
        $this->index();
    }
    
    public function getClienteById($id){
        return $this->clienteDAO->getClienteById($id);
    }

    public function search()
    {
        return $this->clienteDAO->search();
    }
}
