<?php
require_once 'models/ProveedorMdl.php';
require_once 'models/ProveedorDAO.php';

class ProveedorCtr {
    private $proveedorDAO;

    public function __construct() {
        $this->proveedorDAO = new ProveedorDAO();
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
        // Obtener la lista de proveedores desde el modelo
        $proveedores = $this->getAllProveedores();

        // Cargar la vista con los datos
        require_once 'vistas/proveedor/index.php';
    }

    public function getAllProveedores(){
        return $this->proveedorDAO->getAllProveedores();
    }

    public function getPantallaCreate(){
        $this->index();
        require_once 'vistas/proveedor/create.php';
    }

    public function create() {
        // Verifica si se han enviado datos por POST
        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $categoria_fiscal = $_POST['categoria_fiscal'];
            $direccion = $_POST['direccion'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'];
            $saldo = $_POST['saldo'];
            $fechaCreacion = $_POST['fechaCreacion'];
    
            // Crea un nuevo objeto ProveedorMdl con los datos del formulario
            $proveedor = new ProveedorMdl($nombre, $categoria_fiscal, $direccion, $correo, $telefono, $saldo, $fechaCreacion);
    
            // Llama a la función para crear el proveedor en la base de datos
            $this->proveedorDAO->createProveedor($proveedor);
        }
    }

    public function getPantallaEdit() {
        $this->index();
        require_once 'vistas/proveedor/edit.php';
    }

    public function update($id) {
        if(isset($_POST["nombre"])){
            $proveedor = new ProveedorMdl($_POST["nombre"], $_POST["cateogria_fiscal"], $_POST["direccion"], $_POST["correo"], $_POST["telefono"], $_POST["saldo"], $_POST["fechaCreacion"]);
            $proveedor->setId($id);
            $this->proveedorDAO->updateProveedor($proveedor);
        }
    }

    public function getPantallaDelete(){
        require_once 'vistas/proveedor/delete.php';
        $this->index();
    }

    public function delete($id) {
        $this->proveedorDAO->deleteProveedor($id);
    }

    public function getProveedorById($id){
        $this->proveedorDAO->getProveedorById($id);
    }
}