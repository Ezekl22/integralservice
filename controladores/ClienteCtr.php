<?php
require_once 'models/Client.php';
require_once 'models/ClientDAO.php';
require_once 'controladores/GrillaCtr.php';
require_once 'models/GrillaMdl.php';

class ClienteCtr
{
    private $clientDAO;

    public function __construct()
    {
        $this->clientDAO = new ClientDAO();
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $module = isset($_GET['module']) ? $_GET['module'] : '';
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if ($module == 'clientes') {
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
        $clients = $this->clientDAO->getAllClientes();
        require_once 'vistas/cliente/index.php';
    }

    public function getPantallaCreate()
    {
        $this->index();
        require_once 'vistas/cliente/create.php';
    }

    public function create()
    {
        $client = new Client($_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['cuit'], $_POST['iva']);
        $this->clientDAO->createClient($client);
    }

    public function getPantallaEdit()
    {
        $this->index();
        require_once 'vistas/cliente/edit.php';
    }

    public function update($id)
    {
        if (isset($_POST["nombre"])) {
            $client = new Client($_POST["nombre"], $_POST["apellido"], $_POST["email"], $_POST["cuit"], $_POST["categoriafiscal"]);
            $client->setId($id);
            $this->clientDAO->update($client);
        }
    }

    public function delete($id)
    {
        $this->clientDAO->delete($id);
    }

    public function getAllClientes()
    {
        return $this->clientDAO->getAllClientes();
    }

    public function getPantallaDelete()
    {
        require_once 'vistas/cliente/delete.php';
        $this->index();
    }

    public function getClienteById($id)
    {
        return $this->clientDAO->getClienteById($id);
    }

    public function search()
    {
        return $this->clientDAO->search();
    }
}
