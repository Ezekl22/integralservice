<?php
require_once 'models/ProveedorMdl.php';
require_once 'models/ProveedorDAO.php';

class ProveedorCtr {
    private $proveedorDAO;

    public function __construct() {
        $this->proveedorDAO = new ProveedorDAO();
    }

    public function index() {
        // Obtener la lista de proveedores desde el modelo
        $proveedores = $this->proveedorDAO->getAllProveedores();

        // Cargar la vista con los datos
        require_once 'vistas/proveedor/index.php';
    }

    public function getProveedorById($id) {
        return $this->proveedorDAO->getProveedorById($id);
    }

    public function getPantallaCreate(){
        require_once 'vistas/proveedor/create.php';
    }

    public function create() {
        // Mostrar el formulario de creación de proveedor
        require_once 'vistas/proveedor/create.php';
    }

    // public function store($data) {
    //     // Validar los datos del formulario
    //     // ...

    //     // Crear un nuevo proveedor en la base de datos
    //     $proveedor = new ProveedorMdl($data['name'], $data['tax_category'], $data['adress'], $data['phone'], $data['mail'], $data['balance']);
    //     $this->proveedorDAO->createProveedor($proveedor);

    //     // Redireccionar a la página principal de proveedores
    //     header('Location: index.php?action=index');
    // }

    public function getPantallaEdit() {
        // Obtener el proveedor desde el modelo

        // Mostrar el formulario de edición de proveedor con los datos cargados
        require_once 'vistas/proveedor/edit.php';
        $this->index();
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

    public function getAllProveedores(){
        return $this->proveedorDAO->getAllProveedores();
    }

    // public function delete($id) {
    //     // Eliminar el proveedor de la base de datos
    //     $this->proveedorDAO->deleteProveedor($id);

    //     // Redireccionar a la página principal de proveedores
    //     header('Location: index.php?action=index');
    // }
}
