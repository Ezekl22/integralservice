<?php
require_once 'models/ProveedorMdl.php';
require_once 'models/ProveedorDAO.php';
require_once 'controladores/GrillaCtr.php';
require_once 'models/GrillaMdl.php';

class ProveedorCtr
{
    private $proveedorDAO;

    public function __construct()
    {
        $this->proveedorDAO = new ProveedorDAO();
        $module = isset($_GET['module']) ? $_GET['module'] : '';
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $toast = new ToastCtr();
        if ($status == "error") {
            $description = isset($_GET['description']) ? $_GET['description'] : "";
            $toast->mostrarToast($status, $description);
        }
        if ($module == 'proveedores') {
            switch ($action) {
                case 'created':
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $status = isset($_GET['status']) ? $_GET['status'] : "";
                        if ($status != "success") {
                            $this->create();
                        }
                    } else {
                        if ($status == "success") {
                            $toast->mostrarToast("exito", "Proveedor creado");
                        }
                    }
                    break;
                case 'deleted':
                    if ($status != "success") {
                        $this->delete($id);
                    } else if ($status == "success") {
                        $toast->mostrarToast("exito", "Proveedor eliminado");
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
                            $toast->mostrarToast("exito", "Proveedor editado");
                        }
                    }
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
        $grillaMdl = new GrillaMdl(GRILLA_PROVEEDORES, $action == 'searched' && $termino != "" ? $this->search() : $this->getAllProveedores(), [0, 1]);
        $grillaCtr = new GrillaCtr($grillaMdl);

        $proveedores = $this->proveedorDAO->getAllProveedores();
        require_once 'vistas/proveedor/proveedor.php';
    }

    public function getProveedorById($id)
    {
        $proveedor = $this->proveedorDAO->getProveedorById($id);
        if (is_string($proveedor)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer el proveedor", $proveedor);
        }
        return $proveedor;
    }

    public function getAllProveedores()
    {
        $proveedores = $this->proveedorDAO->getAllProveedores();
        if (is_string($proveedores)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al traer los proveedores", $proveedores);
        }
        return $proveedores;
    }

    public function getPantallaCreate()
    {
        $this->index();
        require_once 'vistas/proveedor/create.php';
    }

    public function create()
    {
        // Verifica si se han enviado datos por POST
        if (isset($_POST['nombre'])) {
            $proveedor = new ProveedorMdl(
                $_POST['nombre'],
                $_POST['categoria_fiscal'],
                $_POST['direccion'],
                $_POST['correo'],
                $_POST['telefono'],
                $_POST['cuit'],
                $_POST['saldo']
            );
            $status = $this->proveedorDAO->create($proveedor);
            UtilidadesDAO::getInstance()->showStatus("proveedores", $status, "created");
        }
    }

    public function getPantallaEdit()
    {
        $this->index();
        require_once 'vistas/proveedor/edit.php';
    }

    public function update($id)
    {
        if (isset($_POST["nombre"])) {
            $proveedor = new ProveedorMdl(
                $_POST["nombre"],
                $_POST["categoria_fiscal"],
                $_POST["direccion"],
                $_POST["correo"],
                $_POST["telefono"],
                $_POST["cuit"],
                $_POST["saldo"]
            );
            $proveedor->setId($id);
            $status = $this->proveedorDAO->update($proveedor);
            UtilidadesDAO::getInstance()->showStatus("proveedores", $status, "edited");
        }
    }

    public function getPantallaDelete()
    {
        $gestionPantallaCtr = $_SESSION['session']->getGestionPantallaCtr();
        $gestionPantallaCtr->crearPopUp(new PopUpMdl('delete', 'Eliminar Proveedor', "", BOTONES_POPUP_ELIMINAR, 'index.php?action=delete'));
        $this->index();
    }

    public function delete($id)
    {
        $status = $this->proveedorDAO->delete($id);
        UtilidadesDAO::getInstance()->showStatus("proveedores", $status, "deleted");
    }

    public function search()
    {
        $result = $this->proveedorDAO->search();
        if (is_string($result)) {
            $toast = new ToastCtr();
            $toast->mostrarToast("error", "error al hacer la busqueda", $result);
        }
        return $result;
    }
}