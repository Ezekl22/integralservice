<?php
require_once 'models/Client.php';
require_once 'models/ClientDAO.php';

class ClienteCtr{
    private $clientDAO;

    public function __construct() {
        $this->clientDAO = new ClientDAO();
        $action = isset($_GET['action'])?$_GET['action']:'';
        $id = isset($_GET['id'])?$_GET['id']:'';
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
        // Mostrar el formulario de creación de cliente
        require_once 'vistas/cliente/create.php';

        $client = new Client($data['name'], $data['lastname'], $data['email'], $data['cuit'], $data['iva']);
        $this->clientDAO->createClient($client);
    }

    public function getPantallaEdit() {
        // Obtener el cliente desde el modelo

        // Mostrar el formulario de edición de cliente con los datos cargados
        require_once 'vistas/cliente/edit.php';
        $this->index();
    }

    public function update($id) {

        if(isset($_POST["nombre"])){
            $client = new Client($_POST["nombre"], $_POST["apellido"], $_POST["email"], $_POST["cuit"], $_POST["iva"]);
            $client->setId($id);
            $this->clientDAO->updateClient($client);
        }
    }
    
    public function delete($id) {
        $this->clientDAO->deleteUser($id);
    }

    public function getAllClientes(){
        return $this->clientDAO->getAllClientes();
    }

    // public function delete($id) {
    //     // Eliminar el usuario de la base de datos
    //     $this->userDAO->deleteUser($id);

    // //     // Redireccionar a la página principal de usuarios
    // //     header('Location: index.php?action=index');
    // }
    
    public function getClienteById($id){
        return $this->clientDAO->getClienteById($id);
    }
}
