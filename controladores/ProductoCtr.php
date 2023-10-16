<?php
require_once 'models/ProductoMdl.php';
require_once 'models/ProductoDAO.php';

class ProductoCtr {
    private $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
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
        $productos = $this->productoDAO->getAllProductos();
        require_once 'vistas/producto/index.php';
    }
    public function getProductoById($id) {
        return $this->productoDAO->getProductoById($id);
    }

    public function getAllProductos() {
        return $this->productoDAO->getAllProductos();
    }

    public function getPantallaCreate(){
        require_once 'vistas/producto/create.php';
    }

    public function create() {
        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $marca = $_POST['marca'];
            $detalle = $_POST['detalle'];
            $stock = $_POST['stock'];
            $tipo = $_POST['tipo'];
            $preciocompra = $_POST['preciocompra'];
            $precioventa = $_POST['precioventa'];
    
            $producto = new ProductoMdl($nombre, $marca, $detalle, $stock, $tipo, $preciocompra, $precioventa);
    
            $this->productoDAO->create($producto);
        }
    }
    
    public function getPantallaEdit() {
        require_once 'vistas/producto/edit.php';
        $this->index();
    }

    public function update($id) {
        if(isset($_POST["nombre"])){
            $producto = new ProductoMdl($_POST["nombre"], $_POST["marca"], $_POST["detalle"], $_POST["stock"], $_POST["tipo"], $_POST["preciocompra"], $_POST["precioventa"]);
            $producto->setIdProducto($id);
            $this->productoDAO->updateProducto($producto);
        }
    }

    public function getProductosById($ids){
        return $this->productoDAO->getProductosById($ids);
    }

    // public function create() {
    //     // Mostrar el formulario de creación de usuario
    //     require_once 'vistas/usuario/create.php';
    // }

    // public function store($data) {
    //     // Validar los datos del formulario
    //     // ...

    //     // Crear un nuevo usuario en la base de datos
    //     $user = new User($data['name'], $data['lastname'], $data['type'], $data['username'], $data['password']);
    //     $this->userDAO->createUser($user);

    //     // Redireccionar a la página principal de usuarios
    //     header('Location: index.php?action=index');
    // }

    // public function getPantallaDelete(){
    //     require_once 'vistas/producto/delete.php';
    //     $this->index();
    // }

    // public function delete($id) {
    //     // Eliminar el usuario de la base de datos
    //     $this->productoDAO->deleteProducto($id);

    //     // Redireccionar a la página principal de usuarios
    //     header('Location: index.php?action=index');
    // }
}
