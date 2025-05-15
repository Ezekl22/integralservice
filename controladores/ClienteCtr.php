<?php
require_once 'models/ClienteMdl.php';
require_once 'models/ClienteDAO.php';
require_once 'models/GrillaMdl.php';
require_once 'controladores/GrillaCtr.php';
require_once 'controladores/ToastCtr.php';

class ClienteCtr
{
    private $clienteDAO;
    private static $instance = null;

    public function __construct()
    {
        $this->clienteDAO = new ClienteDAO();
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $module = isset($_GET['module']) ? $_GET['module'] : '';
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : "";
        $toast = new ToastCtr();
        if ($status == "error") {
            $description = isset($_GET['description']) ? $_GET['description'] : "";
            $toast->mostrarToast($status, $description);
        }
        if ($module == 'clientes') {
            switch ($action) {
                case 'created':
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $status = isset($_GET['status']) ? $_GET['status'] : "";
                        if ($status != "success") {
                            $this->create();
                        }
                    } else {
                        if ($status == "success") {
                            $toast->mostrarToast("exito", "Cliente creado");
                        }
                    }
                    break;
                case 'deleted':
                    if ($status != "success") {
                        $this->delete($id);
                    } else if ($status == "success") {
                        $toast->mostrarToast("exito", "Cliente eliminado");
                    }
                    break;
                case 'edited':
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $status = isset($_GET['status']) ? $_GET['status'] : "";
                        if ($status != "success") {
                            $this->update($id);
                        }
                    } else {
                        if ($status == "success") {
                            $toast->mostrarToast("exito", "Cliente editado");
                        }
                    }
                    break;
                case 'searched':
                    $this->search();
                    break;
            }
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ClienteCtr();
        }
        return self::$instance;
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

    public function create()
    {
        $cliente = new Cliente($_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['cuit'], $_POST['categoriafiscal']);
        $status = $this->clienteDAO->createCliente($cliente);
        UtilidadesDAO::getInstance()->showStatus("clientes", $status, "created");
    }

    public function getPantallaEdit()
    {
        $this->index();
        require_once 'vistas/cliente/edit.php';
    }

    public function update($id)
    {
        if (isset($_POST["nombre"])) {
            $cliente = new Cliente($_POST["nombre"], $_POST["apellido"], $_POST["email"], $_POST["cuit"], $_POST["categoriafiscal"]);
            $cliente->setId($id);
            $status = $this->clienteDAO->update($cliente);
            UtilidadesDAO::getInstance()->showStatus("clientes", $status, "edited");
        }
    }

    public function delete($id)
    {
        $status = $this->clienteDAO->delete($id);
        UtilidadesDAO::getInstance()->showStatus("clientes", $status, "deleted");
    }

    public function getAllClientes()
    {
        $clientes = $this->clienteDAO->getAllClientes();
        if (is_string($clientes)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer los clientes", $clientes);
        }
        return $clientes;
    }

    public function getPantallaDelete()
    {
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        $gestionPantallaCtr->crearPopUp(new PopUpMdl('delete', 'Eliminar Cliente', "", BOTONES_POPUP_ELIMINAR, 'index.php?action=delete'));
        $this->index();
    }

    public function getClienteById($id)
    {
        $cliente = $this->clienteDAO->getClienteById($id);
        if (is_string($cliente)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer el cliente", $cliente);
        }
        return $cliente;
    }

    public function search()
    {
        $result = $this->clienteDAO->search();
        if (is_string($result)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al hacer la busqueda", $result);
        }
        return $result;
    }
}
