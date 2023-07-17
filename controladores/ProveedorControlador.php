<?php
require_once 'models/Supplier.php';
require_once 'models/SupplierDAO.php';

class SupplierController {
    private $supplierDAO;

    public function __construct() {
        $this->supplierDAO = new SupplierDAO();
    }

    public function index() {
        // Obtener la lista de proveedores desde el modelo
        $suppliers = $this->supplierDAO->getAllSuppliers();

        // Cargar la vista con los datos
        require_once 'vistas/supplier/index.php';
    }

    public function getPantallaCreate(){
        require_once 'vistas/supplier/create.php';
    }

    public function create() {
        // Mostrar el formulario de creación de proveedor
        require_once 'vistas/supplier/create.php';
    }

    public function store($data) {
        // Validar los datos del formulario
        // ...

        // Crear un nuevo proveedor en la base de datos
        $supplier = new Supplier($data['name'], $data['tax_category'], $data['adress'], $data['phone'], $data['mail'], $data['balance']);
        $this->supplierDAO->createSupplier($supplier);

        // Redireccionar a la página principal de proveedores
        header('Location: index.php?action=index');
    }

    public function getPantallaEdit() {
        // Obtener el proveedor desde el modelo

        // Mostrar el formulario de edición de proveedor con los datos cargados
        require_once 'vistas/supplier/edit.php';
        $this->index();
    }

    public function update($id) {

        if(isset($_POST["nombre"])){
            $supplier = new Supplier($_POST["nombre"], $_POST["cateogria_fiscal"], $_POST["direccion"], $_POST["telefono"], $_POST["correo"], $_POST["saldo"]);
            $supplier->setId($id);
            $this->supplierDAO->updateSupplier($supplier);
        }

        // Redireccionar a la página principal de proveedores
        //header('Location: index.php?module=proveedores');

    }

    public function getPantallaDelete(){
        require_once 'vistas/supplier/delete.php';
        $this->index();
    }

    public function delete($id) {
        // Eliminar el proveedor de la base de datos
        $this->supplierDAO->deleteSupplier($id);

        // Redireccionar a la página principal de proveedores
        header('Location: index.php?action=index');
    }
}
