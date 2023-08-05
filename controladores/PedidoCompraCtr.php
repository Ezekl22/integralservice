<?php
require_once 'models/PedidoCompraMdl.php';
require_once 'models/PedidoCompraDAO.php';
require_once 'controladores/ProveedorCtr.php';
require_once 'controladores/ProductoCtr.php';

class PedidoCompraCtr {
    private $pedidoCompraDAO;
    private $proveedorCtr;
    private $productoCtr;

    public function __construct() {
        $this->pedidoCompraDAO = new PedidoCompraDAO();
        $this->proveedorCtr = new ProveedorCtr();
        $this->productoCtr = new ProductoCtr();
    }

    public function index() {
        // Obtener la lista de usuarios desde el modelo
        $pedidosCompras = $this->getAllPedidosCompras();

        // Cargar la vista con los datos
        require_once 'vistas/pedidos-compra/index.php';
    }

    public function getAllPedidosCompras(){
        return $this->pedidoCompraDAO->getAllPedidosCompras();
    }

    // public function create() {
    //     // Mostrar el formulario de creación de usuario
    //     require_once 'views/user/create.php';
    // }

    // public function store($data) {
    //     // Validar los datos del formulario
    //     // ...

    //     // Crear un nuevo usuario en la base de datos
    //     $user = new User($data['name'], $data['lastname'], $data['type'], $data['username'], $data['password']);
    //     $this->pedidoCompraDAO->createUser($user);

    //     // Redireccionar a la página principal de usuarios
    //     header('Location: index.php?action=index');
    // }
    public function getProveedorByid($id) {
        return $this->proveedorCtr->getProveedorById($id);
    }

    public function getPantallaEdit($id) {
        $pedidoCompra = $this->getPedidoCompraById($id);

        require_once 'vistas/pedidos-compra/edit.php';
    }

    public function getAllClientes(){
        return $this->proveedorCtr->getAllProveedores();
    }

    public function getAllProductos(){
        return $this->productoCtr->getAllProductos();
    }

    public function getProductosPedidoCompraById($id) {
        return $this->pedidoCompraDAO->getProductosPedidoCompraById($id);
    }

    // public function update($id, $data) {
    //     // Validar los datos del formulario
    //     // ...

    //     // Actualizar el usuario en la base de datos
    //     $user = new User($data['name'], $data['lastname'], $data['type'], $data['username'], $data['password']);
    //     $user->setId($id);
    //     $this->pedidoCompraDAO->updateUser($user);
    // }

    public function getPedidoCompraById($id){
        return $this->pedidoCompraDAO->getPedidoCompraById($id);
    }

    // public function delete($id) {
    //     // Eliminar el usuario de la base de datos
    //     $this->pedidoCompraDAO->deleteUser($id);

    //     // Redireccionar a la página principal de usuarios
    //     header('Location: index.php?action=index');
    // }
}
