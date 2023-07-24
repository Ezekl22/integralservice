<?php
require_once 'models/Client.php';
require_once 'models/ClientDAO.php';

class ClientController {
    private $clientDAO;

    public function __construct() {
        $this->clientDAO = new ClientDAO();
    }

    public function index() {
        // Obtener la lista de clientes desde el modelo
        $clients = $this->clientDAO->getAllClients();

        // Cargar la vista con los datos
        require_once 'vistas/client/index.php';
    }

    public function getPantallaCreate(){
        require_once 'vistas/client/create.php';
    }

    public function create() {
        // Mostrar el formulario de creación de cliente
        require_once 'vistas/client/create.php';
    }

    public function store($data) {
        // Validar los datos del formulario
        // ...

        // Crear un nuevo cliente en la base de datos
        $client = new Client($data['name'], $data['lastname'], $data['email'], $data['cuit'], $data['iva']);
        $this->clientDAO->createClient($client);

        // Redireccionar a la página principal de clientes
        header('Location: index.php?action=index');
    }

    public function getPantallaEdit() {
        // Obtener el cliente desde el modelo

        // Mostrar el formulario de edición de cliente con los datos cargados
        require_once 'vistas/client/edit.php';
        $this->index();
    }

    public function update($id) {

        if(isset($_POST["nombre"])){
            $client = new Client($_POST["nombre"], $_POST["apellido"], $_POST["email"], $_POST["cuit"], $_POST["iva"]);
            $client->setId($id);
            $this->clientDAO->updateClient($client);
        }

        // Redireccionar a la página principal de clientes
        //header('Location: index.php?module=clientes');

    }

    public function getPantallaDelete(){
        require_once 'vistas/client/delete.php';
        $this->index();
    }

    public function delete($id) {
        // Eliminar el cliente de la base de datos
        $this->clientDAO->deleteClient($id);

        // Redireccionar a la página principal de clientes
        header('Location: index.php?action=index');
    }

    public function getClientById($id){
        return $this->clientDAO->getClientById($id);
    }
}
