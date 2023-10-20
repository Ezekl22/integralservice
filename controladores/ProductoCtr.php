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
        $this->index();
        require_once 'vistas/producto/edit.php';
    }

    public function update($id) {
        if(isset($_POST["nombre"])){
            $producto = new ProductoMdl($_POST["nombre"], $_POST["marca"], $_POST["detalle"], $_POST["stock"], $_POST["tipo"], $_POST["preciocompra"], $_POST["precioventa"]);
            $producto->setIdProducto($id);
            $this->productoDAO->update($producto);
        }
    }

    public function getProductosById($ids){
        return $this->productoDAO->getProductosById($ids);
    }

    public function getPantallaDelete(){
        require_once 'vistas/producto/delete.php';
        $this->index();
    }

    public function delete($id) {
        $this->productoDAO->delete($id);
    }
}
