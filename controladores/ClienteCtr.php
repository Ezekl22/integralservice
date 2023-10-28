<?php
require_once 'models/Client.php';
require_once 'models/ClientDAO.php';

class ClienteCtr{
    private $clientDAO;

    public function __construct() {
        $this->clientDAO = new ClientDAO();
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
            }
        }
    }

    public function index() {
        // Obtener la lista de clientes desde el modelo
        $clients = $this->clientDAO->getAllClientes();

        // Cargar la vista con los datos
        require_once 'vistas/cliente/index.php';
    }

    public function getPantallaCreate(){
        $this->index();
        require_once 'vistas/cliente/create.php';
    }

    public function create() {
        $client = new Client($_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['cuit'], $_POST['iva']);
        $this->clientDAO->createClient($client);
    }

    public function getPantallaEdit() {
        $this->index();
        require_once 'vistas/cliente/edit.php';
    }

    public function update($id) {
        if(isset($_POST["nombre"])){
            $client = new Client($_POST["nombre"], $_POST["apellido"], $_POST["email"], $_POST["cuit"], $_POST["categoriafiscal"]);
            $client->setId($id);
            $this->clientDAO->update($client);
        }
    }
    
    public function delete($id) {
        $this->clientDAO->delete($id);
    }

    public function getAllClientes(){
        return $this->clientDAO->getAllClientes();
    }

    public function getPantallaDelete(){
        require_once 'vistas/cliente/delete.php';
        $this->index();
    }
    
    public function getClienteById($id){
        return $this->clientDAO->getClienteById($id);
    }
}
